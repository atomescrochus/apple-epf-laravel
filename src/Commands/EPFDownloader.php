<?php

namespace Appwapp\EPF\Commands;

use Appwapp\EPF\EPFCrawler;
use Appwapp\EPF\Exceptions\ModelNotFoundException;
use Appwapp\EPF\Traits\FeedCredentials;
use Appwapp\EPF\Traits\FileStorage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;

class EPFDownloader extends EPFCommand
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
        {--skip-confirm : skip the confirmation prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download the EPF export files to local storage.';

    /**
     * The Apple's EPF credentials.
     *
     * @var object
     */
    private object $credentials;

    /**
     * The EPF local file paths.
     *
     * @var object
     */
    private object $paths;

    /**
     * The EPF crawler.
     *
     * @var \Appwapp\EPF\EPFCrawler
     */
    private EPFCrawler $epf;

    /**
     * Wether the MD5 check has failed or not.
     * 
     * @var bool
     */
    private bool $md5ChecksFailed;

    /**
     * Wether if the command should show output or not.
     *
     * @var bool
     */
    private bool $quiet;

    /**
     * The progress bar.
     * @var mixed
     */
    private $downloadProgressBar;

    /**
     * Bytes in the previous progress bar iteration.
     *
     * @var int
     */
    private int $bytesInPreviousIteration;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->credentials     = $this->getCredentials();
        $this->paths           = $this->getEPFFilesPaths();
        $this->md5ChecksFailed = false;
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

            // fetch the model based on the file name and group
            $model = 'Appwapp\EPF\Models\\'. Str::studly($this->group)  .'\\' . Str::studly(Str::replace('.tbz', '', $filename));
            if (! class_exists($model)) {
                throw new ModelNotFoundException("Model '$model' does not exists. Make sure 'apple-epf-laravel' is up to date.");
            }

            // Check if we need to skip that file/model
            if (! in_array($model, config('apple-epf.included_models'))) {
                $this->comment("Skipped download of {$filename}");
                return;
            }

            $this->line("Starting download of {$filename}...");

            $this->download($link);
            $this->md5Check($link);

            $this->info("Finished download of {$filename}");
        });
    }

    /**
     * Downloads a file.
     *
     * @param string $link
     *
     * @return void
     */
    private function download(string $link)
    {
        $linkMD5 = $link.".md5";
        $filename = basename($link);
        $filenameMD5 = basename($linkMD5);
        
        // Make sure file exists for the sink to work
        Storage::put("{$this->paths->get('storage')->archive}/{$this->variableFolders}/{$filename}", "");
        Storage::put("{$this->paths->get('storage')->archive}/{$this->variableFolders}/{$filenameMD5}", "");
        
        $client = new Client();
        $client->request('GET', $link, [
            'auth'     => [$this->credentials->login, $this->credentials->password],
            'sink'     => "{$this->paths->get('system')->archive}/{$this->variableFolders}/{$filename}",
            'progress' => function ($downloadTotal, $downloadedBytes) {
                $this->progress($downloadTotal, $downloadedBytes);
            },
        ]);

        $client->request('GET', $linkMD5, [
            'auth'     => [$this->credentials->login, $this->credentials->password],
            'sink'     => "{$this->paths->get('system')->archive}/{$this->variableFolders}/{$filenameMD5}",
            'progress' => function ($downloadTotal, $downloadedBytes) {
                $this->progress($downloadTotal, $downloadedBytes);
            },
        ]);
    }

    /**
     * The progress bar handler.
     *
     * @param mixed $downloadTotal
     * @param mixed $downloadedBytes
     *
     * @return void
     */
    private function progress($downloadTotal, $downloadedBytes)
    {
        if ($this->downloadProgressBar == null && $downloadTotal != 0) {
            // no progress bar and download started
                
            $this->bytesInPreviousIteration = 0;
            $this->downloadProgressBar = new ProgressBar($this->output, $downloadTotal);
            $this->downloadProgressBar->setFormat('very_verbose');
        } else if ($this->downloadProgressBar != null && $downloadTotal == $downloadedBytes) {
            // there is a progress bar and the download it finished
                
            $this->downloadProgressBar->finish();
            $this->downloadProgressBar->clear();
            $this->downloadProgressBar = null;
        } else if ($this->downloadProgressBar != null) {
            // at this point, we're downloading and got a progress bar

            $this->downloadProgressBar->advance($downloadedBytes - $this->bytesInPreviousIteration);
            $this->bytesInPreviousIteration = $downloadedBytes;
        }
    }

    /**
     * Checks the MD5 of the file.
     *
     * @param string $file
     *
     * @return bool
     */
    private function md5Check(string $file)
    {
        $filename        = basename($file);
        $md5Filename     = $filename.".md5";
        $fileLocation    = "{$this->paths->get('system')->archive}/{$this->variableFolders}/{$filename}";
        $md5FileLocation = "{$this->paths->get('storage')->archive}/{$this->variableFolders}/{$md5Filename}";

        $md5File = md5_file($fileLocation);
        $md5 = trim(substr(Storage::get($md5FileLocation), -33));

        if ($md5File === $md5) {
            $this->info("Checksum: ✅  passed! Deleting the .md5...");
            Storage::delete($md5FileLocation);
            return true;
        }
            
        $this->error('Checsum: ❌  failed! Deleting both files!');
        Storage::delete($fileLocation);
        Storage::delete($md5FileLocation);
        return false;
    }
}
