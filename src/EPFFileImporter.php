<?php

namespace Atomescrochus\EPF;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class EPFFileImporter
{
    protected $file;
    protected $connection;
    protected $specialChars;
    protected $exportType;
    protected $columns;
    protected $primaryKeys;
    public $duration;
    public $totalRows;

    public function __construct($file)
    {
        $this->specialChars = (object) [
            'fs' => "\x01", // field separator
            'rs' => "\x02\n", // record separator
            'co' => "#", // comments delimiter,
            'le' => "##legal", // legal comments delimiter
        ];
        $this->connection = 'apple-epf';
        $this->totalRows = 0;

        $this->file = new \SplFileObject($file);
        $this->getRelevantInformationFromFile();
        $this->checkForTable();
    }

    public function startImport()
    {
        $start = Carbon::now();
        // fetch the model based on the file name
        $model = "Atomescrochus\EPF\Models\iTunes\\";
        $model .= studly_case($this->file->getFilename());

        $this->file->seek(0);

        while (!$this->file->eof()) {
            $line = $this->file->fgets();
        
            if ($line != "" && !str_contains($line, "#")) {
                //a.k.a not the last, or a comment
                
                $line = str_replace($this->specialChars->rs, "", $line); // remove record separator
                $values = explode($this->specialChars->fs, $line); // divide values
                $columns = collect($this->columns->keys());
                $data = collect();

                $columns->each(function ($name, $key) use ($data, $values) {
                    $value = empty($values[$key]) ? null : $values[$key];
                    $data->put($name, $value);
                });

                $data = $data->map(function ($item, $key) {
                    if (str_contains($key, "release_date")) {
                        $item = str_replace(' ', '-', $item); // format correctly for mysql date time
                    }

                    return $item;
                });

                $primaryKey = [$this->primaryKeys->first() => $data->pull($this->primaryKeys->first())];

                $row = $model::updateOrCreate(
                    $primaryKey,
                    $data->toArray()
                );

                $this->totalRows++;
            }
        }

        $this->file = null;
        $this->duration = $start->diffinSeconds(Carbon::now());
    }

    private function getRelevantInformationFromFile()
    {
        while (!$this->file->eof()) {
            $line = $this->file->fgets(); // get the line
            $line = str_replace($this->specialChars->rs, "", $line); // remove record separator, we already read line by line anyway

            if ($this->file->key() == 0) {
                // first line, column names
                $this->getColumnNames($line);
            }

            if ($this->file->key() == 1) {
                // second line, primary key
                $this->getPrimaryKey($line);
            }

            if ($this->file->key() == 2) {
                // third line, columns types
                $this->setColumnTypes($line);
            }

            if ($this->file->key() == 3) {
                // fourth line, export type
                $this->getExportType($line);
            }

            if ($line[0] != $this->specialChars->co) {
                break;
            }
        }
    }

    private function checkForTable()
    {
        $tableName = $this->file->getFilename();
        $tableExists = Schema::connection($this->connection)->hasTable($tableName);

        if (!$tableExists) {
            $primaryKeys = implode(",", $this->primaryKeys->toArray());
            $columns = collect();

            $this->columns->each(function ($type, $name) use ($columns) {
                $columns->push("{$name} {$type}");
            });

            $columns = implode(", ", $columns->toArray());
            $sql = "CREATE TABLE {$tableName} ({$columns}, PRIMARY KEY($primaryKeys));";

            DB::connection($this->connection)->statement($sql);
        }
    }

    private function getExportType($line)
    {
        $this->exportType = str_replace("#exportMode:", "", $line); // remove comment character and info
    }

    private function getPrimaryKey($line)
    {
        
        $line = str_replace("#primaryKey:", "", $line); // remove comment character and info
        $this->primaryKeys = collect(explode($this->specialChars->fs, $line));
    }

    private function getColumnNames($line)
    {
        $line = substr($line, 1); // remove comment character
        $this->columns = collect(explode($this->specialChars->fs, $line));
    }

    private function setColumnTypes($line)
    {
        $line = str_replace("#dbTypes:", "", $line); // remove comment character and info
        $line = collect(explode($this->specialChars->fs, $line));

        $columns = collect([]);

        while ($this->columns->count() > 0) {
            $columns->put($this->columns->shift(), $line->shift());
        }

        $this->columns = $columns;
    }
}
