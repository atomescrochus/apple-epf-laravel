<?php

namespace Appwapp\EPF;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Appwapp\EPF\Exceptions\ModelNotFoundException;
use Appwapp\EPF\Exceptions\TableNotFoundException;

class EPFFileImporter
{
    /**
     * The file to import.
     *
     * @var SplFileObject
     */
    protected ?\SplFileObject $file;

    /**
     * The connection name.
     *
     * @var string
     */
    protected string $connection;

    /**
     * The number of chunks to cut the transaction.
     *
     * @var int
     */
    protected int $chunks;

    /**
     * The special characters used in EPF feeds.
     *
     * @var object
     */
    protected object $specialChars;

    /**
     * Type of the export.
     *
     * @var string
     */
    protected string $exportType;

    /**
     * Collection of columns.
     *
     * @var \Illuminate\Support\Collection
     */
    protected Collection $columns;

    /**
     * Collection of primary keys.
     *
     * @var \Illuminate\Support\Collection
     */
    protected Collection $primaryKeys;

    /**
     * Duration in seconds.
     *
     * @var int
     */
    public int $duration;

    /**
     * Total rows imported.
     *
     * @var int
     */
    public int $totalRows;

    /**
     * Wether the file was skipped or not.
     *
     * @var bool
     */
    public bool $skipped = false;

    /**
     * Group to import to.
     *
     * @var string
     */
    protected string $group;

    /**
     * The model classname
     *
     * @var string
     */
    protected string $model;

    /**
     * Constructs a new instance.
     *
     * @param  string  $file  The file to import
     * @param  string  $group The group to import to
     */
    public function __construct(string $file, string $group)
    {
        // Setup the special characters
        $this->specialChars = (object) [
            'field_separator'    => "\x01",
            'record_separator'   => "\x02\n",
            'comments_delimiter' => "#",
            'legal'              => "##legal",
        ];

        // Get the connection from the configuration
        $this->connection = config('apple-epf.database_connection');
        $this->chunks     = config('apple-epf.database_importation_chunks');
        $this->totalRows  = 0;

        // Get the file
        $this->group = $group;
        $this->file  = new \SplFileObject($file);

        // Fetch the model based on the file name and group
        $this->model = 'Appwapp\EPF\Models\\'. Str::studly($this->group)  .'\\' . Str::studly($this->file->getFilename());

        // Remove any number in case of multiple files per model
        $this->model = preg_replace('/[0-9]*/', '', $this->model);
    }

    /**
     * Starts the importation.
     *
     * @return void
     */
    public function startImport(): void
    {
        // Get the file relevant information
        $this->getRelevantInformationFromFile();

        // Verifies the dynamic model and 
        // checks if it needs to be ignored
        if ($this->verifyModel() === false) {
            // Ignore the model, return as done
            $this->skipped = true;
            return;
        }

        $start = Carbon::now();

        $this->file->seek(0);

        // Begin the database transaction
        DB::connection($this->connection)->beginTransaction();

        try {
            while (! $this->file->eof()) {
                $line = $this->file->fgets();

                // Skips end of file or comments
                if ($line === "" || str_starts_with($line, "#")) {
                    continue;
                }

                // Read line until a record separator is found
                // Can happen if a value contains a line feed \n
                while (strpos($line, $this->specialChars->record_separator) === false && ! $this->file->eof()) {
                    $line .= $this->file->fgets();
                }

                $line    = str_replace($this->specialChars->record_separator, "", $line); // remove record separator
                $values  = explode($this->specialChars->field_separator, $line); // divide values
                $columns = collect($this->columns->keys());
                $data    = collect();

                $columns->each(function ($name, $key) use ($data, $values) {
                    $data->put($name, $values[$key] !== '' ? $values[$key] : null);
                });

                $data = $data->map(function ($item, $key) {
                    if (str_contains($key, "release_date")) {
                        $item = str_replace(' ', '-', $item); // format correctly for mysql date time
                    }

                    return $item;
                });

                // Generate the composite or single primary key
                $primaryKeys = [];
                foreach ($this->primaryKeys->all() as $primaryKey) {
                    $primaryKeys[$primaryKey] = $data->pull($primaryKey);
                }

                // Either update or create via the model
                $this->model::updateOrCreate($primaryKeys, $data->toArray());
                $this->totalRows++;

                // Commit the transaction by chunks
                // To not go over the database insert limit if any
                if ($this->totalRows % $this->chunks === 0) { 
                    DB::connection($this->connection)->commit();
                }
            }

            // Do a last commit after the loop to commit the remainder
            DB::connection($this->connection)->commit();
        } catch (QueryException $exception) {
            DB::connection($this->connection)->rollBack();
            throw $exception;
        }

        $this->file     = null;
        $this->duration = $start->diffinSeconds(Carbon::now());
    }   

    /**
     * Gets the relevant information from the file.
     *
     * @return void
     */
    private function getRelevantInformationFromFile(): void
    {
        while (! $this->file->eof()) {
            $line = $this->file->fgets(); // get the line
            $line = str_replace($this->specialChars->record_separator, "", $line); // remove record separator, we already read line by line anyway

            if ($this->file->key() == 1) {
                // first line, column names
                $this->setColumnNames($line);
            }

            if ($this->file->key() == 2) {
                // second line, primary key
                $this->setPrimaryKey($line);
            }

            if ($this->file->key() == 3) {
                // third line, columns types
                $this->setColumnTypes($line);
            }

            if ($this->file->key() == 4) {
                // fourth line, export type
                $this->setExportType($line);
            }

            if ($line[0] != $this->specialChars->comments_delimiter) {
                break;
            }
        }
    }

    /**
     * Verifies if the model exists, if the model should be
     * included in the import and if the table exists.
     *
     * @throws ModelNotFoundException
     * @throws TableNotFoundException
     * 
     * @return bool
     */
    private function verifyModel(): bool
    {
        // Check if model exists
        if (! class_exists($this->model)) {
            throw new ModelNotFoundException("Model '{$this->model}' does not exists. Make sure 'apple-epf-laravel' is up to date.");
        }

        // Check if model is included in config
        if (! in_array($this->model, config('apple-epf.included_models'))) {
            return false;
        }

        // Make sure the table exists, a.k.a. migrations have been run
        $tableName = $this->model::getTableName();
        if (! Schema::connection($this->connection)->hasTable($tableName)) {
            throw new TableNotFoundException("The `{$tableName}` table was not found in the '{$this->connection}' connection. Please run the 'apple-epf-laravel' migrations or adjust the configuration.");
        }

        return true;
    }

    /**
     * Sets the export type.
     *
     * @param  string $line
     *
     * @return void
     */
    private function setExportType(string $line): void
    {
        $this->exportType = str_replace("#exportMode:", "", $line); // remove comment character and info
    }

    /**
     * Sets the primary key.
     *
     * @param  string $line
     *
     * @return void
     */
    private function setPrimaryKey(string $line): void
    {
        $line       = str_replace("#primaryKey:", "", $line); // remove comment character and info
        $this->primaryKeys = collect(explode($this->specialChars->field_separator, $line));
    }

    /**
     * Sets the column names.
     * 
     * @param string $line
     *
     * @return void
     */
    private function setColumnNames(string $line): void
    {
        $line   = substr($line, 1); // remove comment character
        $this->columns = collect(explode($this->specialChars->field_separator, $line));
    }

    /**
     * Sets the column types.
     *
     * @param  string $line
     *
     * @return void
     */
    private function setColumnTypes(string $line): void
    {
        $line    = str_replace("#dbTypes:", "", $line); // remove comment character and info
        $line    = collect(explode($this->specialChars->field_separator, $line));

        $columns = collect([]);

        while ($this->columns->count() > 0) {
            $columns->put($this->columns->shift(), $line->shift());
        }

        $this->columns = $columns;
    }
}