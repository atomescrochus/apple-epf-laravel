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
    protected $primaryKey;

    public function __construct($file)
    {
        $this->specialChars = (object) [
            'fs' => "\x01", // field separator
            'rs' => "\x02\n", // record separator
            'co' => "#", // comments delimiter,
            'le' => "##legal", // legal comments delimiter
        ];
        $this->connection = 'apple-epf';

        $this->file = new \SplFileObject($file);
        $this->getRelevantInformationFromFile();
        $this->checkForTable();
    }

    public function checkForTable()
    {
        $tableName = $this->file->getFilename();
        $tableExists = Schema::connection($this->connection)->hasTable($tableName);

        if (!$tableExists) {
            $columns = collect();
            $this->columns->each(function ($type, $name) use ($columns) {
                $columns->push("{$name} {$type}");
            });

            $columns = implode(", ", $columns->toArray());
            $sql = "CREATE TABLE {$tableName} ({$columns}, PRIMARY KEY ($this->primaryKey));";

            DB::connection($this->connection)->statement($sql);
        }
    }

    private function getRelevantInformationFromFile()
    {
        // $this->linesTotal = "";
        // $this->lines = $this->getTotalNumberofLines();
        // $this->file->seek

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

    private function getExportType($line)
    {
        $this->exportType = str_replace("#exportMode:", "", $line); // remove comment character and info
    }

    private function getPrimaryKey($line)
    {
        $this->primaryKey = str_replace("#primaryKey:", "", $line); // remove comment character and info
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

    public function getTotalNumberofLines()
    {
        $this->file->seek(PHP_INT_MAX);
        return $this->file->key() + 1;
    }
}
