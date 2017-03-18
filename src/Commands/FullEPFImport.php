<?php

namespace Atomescrochus\EPF\Commands;

use Atomescrochus\EPF\EPFCrawler;
use Atomescrochus\EPF\Exceptions\MissingCommandOptions;
use Atomescrochus\EPF\Exceptions\NotSupported;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class FullEPFImport extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'epf:import {--type= : Type of import to perform. Either "full" or "incremental"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will start full an import of the EPF in your database.';

    private $type;
    private $credentials;
    private $epf;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->credentials = (object) [
            'login' => config('apple-epf.user_id'),
            'password' => config('apple-epf.password'),
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line("");
        $this->comment("This might take a while, the files are huge.");
        $this->checkForType();
        $this->epf = new EPFCrawler($this->credentials);

        if ($this->type == "full") {
            $this->startFullImportProcess();
        }

        $this->comment("We're done! Congratulations!");
    }

    private function startFullImportProcess()
    {
        $this->info("We're fetching the current folder for a list of files...");

        dd($this->epf);

        $this->info("We got them!");
    }

    private function checkForType()
    {
        if (is_null($this->option('type'))) {
            throw MissingCommandOptions::type();
        }

        if ($this->option('type') == "incremental") {
            throw NotSupported::incrementalImport();
        }

        $this->type = $this->option('type');
    }
}
