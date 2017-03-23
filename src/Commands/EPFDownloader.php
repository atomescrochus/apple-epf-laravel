<?php

namespace Atomescrochus\EPF\Commands;

use Atomescrochus\EPF\EPFCrawler;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;

class EPFDownloader extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'epf:download {--type= : Which group of files to download. Either "full" or "incremental"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will start downloading the EPF files to storage.';

    private $credentials;
    private $epf;
    private $downloadedFiles;
    private $group;
    private $md5ChecksFailed;
    private $downloadProgressBar;
    private $fullPathToFiles;

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

        $this->md5ChecksFailed = false;
        $this->fullPathToFiles = storage_path()."/app/epf-imports/{$this->group}/archives";
        $this->pathForStorageToFiles = "epf-imports/{$this->group}/archives";
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (is_null($this->option('type'))) {
            throw MissingCommandOptions::type();
        }

        // check type legal?

        $this->group = $this->option('type');

        $this->line("");
        $this->line("👋. Welcome to the Apple EPF downloader! 👋");

        if ($this->confirm("Are you ready?")) {
            $this->epf = new EPFCrawler($this->credentials);

            $this->startTasks($this->option('type'));

            $this->comment("We're done! Congratulations!");
        }
    }

    private function startTasks()
    {
        $this->line("");
        $this->line("We're starting to download the '{$this->group}' group of files. Depending on your connection, this might take a long time!");

        $links = $this->epf->links->get($this->group);
        $countLinks = count($links);

        $this->info("There is a total of {$countLinks} files to download.");

        $links->each(function ($link) {
            $this->line("");
            $this->line("Starting download of {$link}");
            $this->line("");

            $this->download("https://feeds.itunes.apple.com/feeds/epf/v3/full/current/incremental/current/match20170323.tbz");

            $this->line("");
            $this->line("Finished download of {$link}");
            $this->line("");
        });
    }

    private function download($link)
    {
        $this->downloadedFiles = collect();
        $filename = basename($link);
        
        // make sure file exists
        // todo: this overwrites the file if it exists, should be better
        Storage::put("{$this->pathForStorageToFiles}/{$filename}", "");

        $saveTo = "{$this->fullPathToFiles}/{$filename}";

        $client = new Client();

        $client->request('GET', $link, [
            'auth' => [$this->credentials->login, $this->credentials->password],
            'sink' => $saveTo,
            'progress' => function ($downloadTotal, $downloadedBytes, $uploadTotal, $uploadedBytes) {
                if ($this->downloadProgressBar == null && $downloadTotal != 0) {
                    // no progress bar and download started
                        
                    $this->bytesInPreviousIteration = 0; //
                    $this->downloadProgressBar = new ProgressBar($this->output, $downloadTotal);
                    $this->downloadProgressBar->setFormat('very_verbose');
                } else if ($this->downloadProgressBar != null && $downloadTotal == $downloadedBytes) {
                    // there is a progress bar and the download it finished
                        
                    $this->downloadProgressBar->finish();
                    $this->downloadProgressBar = null;
                } else if ($this->downloadProgressBar != null) {
                    // at this point, we're downloading and got a progress bar

                    $this->downloadProgressBar->advance($downloadedBytes - $this->bytesInPreviousIteration);
                    $this->bytesInPreviousIteration = $downloadedBytes;
                }
            },
        ]);

        $this->md5Check($saveTo);

        $this->downloadedFiles->push($saveTo);
    }

    private function md5Check($fileLocation)
    {
        $md5Filename = basename($fileLocation.".md5");
        $md5Location = "{$this->fullPathToFiles}/{$md5Filename}";

        $md5File = md5_file($fileLocation);
        $md5 = trim(substr(Storage::get("{$this->pathForStorageToFiles}/{$md5Filename}"), -33));

        if ($md5File == $md5) {
            $this->line("");
            $this->line("Checksum: ✅  passed!");
            $this->line("");
            return true;
        } else {
            die("Checsum: ❌  failed! We'll have to quick, sorry!");
        }
    }
}
