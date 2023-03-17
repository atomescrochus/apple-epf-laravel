<?php

namespace Appwapp\EPF\Commands;

use Appwapp\EPF\Jobs\ImportJob;
use Appwapp\EPF\Models\Itunes\KeyValue;
use Appwapp\EPF\Traits\FileStorage;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Support\Facades\DB;

class EPFPrune extends EPFCommand
{
    use FileStorage;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'epf:prune
        {--before-date= : prune data before that timestamp, by default will check the key_value table for the lastFullExportDate}
        {--skip-confirm : skip the confirmation prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will help prune the data after a full feed import.';

 /**
     * The connection name.
     *
     * @var string
     */
    protected string $connection;

    public function __construct()
    {
        parent::__construct();

        $this->connection = config('apple-epf.database_connection');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get the before-date timestamp
        $timestamp = $this->option('before-date');
        $models    = config('apple-epf.included_models');

        // Check if the key/value 
        if ($timestamp === null) {
            $keyValue  = KeyValue::where('key_', 'lastFullExportDate')->first();
            $timestamp = $keyValue->value_;
            $this->line("Checks key_value");
        }

        // Begin the database transaction
        DB::connection($this->connection)->beginTransaction();

        // Prune old data
        try {
            foreach ($models  as $model) {
                $model::where('export_date', '<', $timestamp)->delete();
            }
        } catch (QueryException $exception) {
            DB::connection($this->connection)->rollBack();
            throw $exception;
        }

        if ($this->option('skip-confirm') || $this->confirm(sprintf("Are you ready to prune old data from %s tables?", count($models)))) {
            // Commit transaction
            DB::connection($this->connection)->commit();
            $this->comment("We're done pruning!");
            return;
        }

        // Not confirmed, rollback
        DB::connection($this->connection)->rollBack();
    }
}
