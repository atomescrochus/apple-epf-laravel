<?php

namespace Appwapp\EPF\Commands;

use Appwapp\EPF\EPFCrawler;
use Appwapp\EPF\Exceptions\ModelNotFoundException;
use Appwapp\EPF\Jobs\DownloadJob;
use Appwapp\EPF\Traits\FeedCredentials;
use Appwapp\EPF\Traits\FileStorage;
use Illuminate\Support\Str;

class EPFDownload extends EPFCommand
{
    use FeedCredentials, FileStorage;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'epf:download
        {--type= : the type of import, either "full", or "incremental"}
        {--group= : the group of import, either "itunes", "match", "popularity" or "pricing"}
        {--skip-confirm : skip the confirmation prompt}
        {--chain-jobs : chain the next jobs after the download}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download the EPF export files to local storage.';

    /**
     * The EPF crawler.
     *
     * @var \Appwapp\EPF\EPFCrawler
     */
    private EPFCrawler $epf;

    /**
     * The paths.
     *
     * @var object
     */
    private $paths;

    /**
     * The credentials.
     *
     * @var object
     */
    private $credentials;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->credentials = $this->getCredentials();
        $this->paths       = $this->getEPFFilesPaths();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line("");
        $this->line("👋 Welcome to the Apple EPF downloader! 👋");

        // Get the group and type
        $this->gatherUserInput();

        if ($this->option('skip-confirm') || $this->confirm("Are you ready to launch the downloads?")) {
            $this->epf = new EPFCrawler();
            $this->startTasks();

            $this->line('');
            $this->comment("We're done downloading!");
        }
    }

    /**
     * Start the download tasks.
     *
     * @return void
     */
    private function startTasks(): void
    {
        $this->line("");
        $this->line("We're starting to download the '{$this->group}|{$this->type}' group of files. Depending on your connection, this might take a long time!");

        $links      = $this->epf->links->get($this->type)->get($this->group);
        $countLinks = count($links);
           
        $this->info("There is a total of $countLinks files to download.");

        $links->each(function ($link) {
            $this->line("");
            $filename = basename($link);

            // Fetch the model based on the file name and group
            $model = 'Appwapp\EPF\Models\\'. Str::studly($this->group)  .'\\' . Str::studly(Str::replace('.tbz', '', $filename));

            // Remove any number, in case of multiple files for same model
            $model = preg_replace('/[0-9]*/', '', $model);

            // If model does not exist, throw an error
            if (! class_exists($model)) {
                throw new ModelNotFoundException("Model '$model' does not exists. Make sure 'apple-epf-laravel' is up to date.");
            }

            // Check if we need to skip that file/model
            if (! in_array($model, config('apple-epf.included_models'))) {
                $this->comment("Skipped download of {$filename}");
                return;
            }

            $this->line("Dispatching download of {$filename}...");
            DownloadJob::dispatch($link, $this->group, $this->type)->onQueue(config('apple-epf.queue'));
        });
    }    
}
