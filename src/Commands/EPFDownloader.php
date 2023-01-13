<?php

namespace Appwapp\EPF\Commands;

use Appwapp\EPF\EPFCrawler;
use Appwapp\EPF\Exceptions\MissingCommandOptions;
use Appwapp\EPF\Traits\FeedCredentials;
use Appwapp\EPF\Traits\FileStorage;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;

class EPFDownloader extends Command
{
    use FeedCredentials, FileStorage;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'epf:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will help download the EPF files.';

    private $credentials;
    private $paths;
    private $epf;
    private $type;
    private $group;
    private $md5ChecksFailed;
    private $downloadProgressBar;
    private $fullPathToFiles;
    private $variableFolders;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->credentials = $this->getCredentials();
        $this->paths = $this->getEPFFilesPaths();

        $this->md5ChecksFailed = false;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        dd("yolo");
        $this->line("");
        $this->line("👋. Welcome to the Apple EPF downloader! 👋");

        $this->type = $this->choice('What is the type of files you want to download?', ['full', 'incremental'], 0);
        $this->group = $this->choice('What is the group of files you want to download?', ['itunes', 'match', 'popularity', 'pricing'], 0);

        $this->variableFolders = "{$this->group}/{$this->type}";

        if ($this->confirm("Are you ready to launch the downloads?")) {
            $this->epf = new EPFCrawler();
            $this->startTasks();
            $this->comment("We're done downloading!");
        }
    }

    private function startTasks()
    {
        $this->line("");
        $this->line("We're starting to download the '{$this->group}|{$this->type}' group of files. Depending on your connection, this might take a long time!");

        $links = $this->epf->links->get($this->type)->filter(function ($link) {
            return str_contains($link, $this->group);
        });
        // $links = collect(["https://feeds.itunes.apple.com/feeds/epf/v3/full/current/incremental/current/match20170323.tbz"]); // debug only
        $countLinks = count($links);
        $this->info("There is a total of {$countLinks} files to download.");

        $links->each(function ($link) {
            $filename = basename($link);

            $this->line("");
            $this->info("Starting download of {$filename}");

            $this->download($link);
            $this->md5Check($link);

            $this->info("Finished download of {$filename}");
            $this->line("");
        });
    }

    private function download($link)
    {
        $this->line("");
        $linkMD5 = $link.".md5";
        $filename = basename($link);
        $filenameMD5 = basename($linkMD5);
        
        // make sure file exists
        // todo: this action overwrites the file if it exists, should be better...
        $file = Storage::put("{$this->paths->get('storage')->archive}/{$this->variableFolders}/{$filename}", "");
        $fileMd5 = Storage::put("{$this->paths->get('storage')->archive}/{$this->variableFolders}/{$filenameMD5}", "");
        
        $client = new Client();
        $fileResponse = $client->request('GET', $link, [
            'auth' => [$this->credentials->login, $this->credentials->password],
            'sink' => "{$this->paths->get('system')->archive}/{$this->variableFolders}/{$filename}",
            'progress' => function ($downloadTotal, $downloadedBytes, $uploadTotal, $uploadedBytes) {
                if ($this->downloadProgressBar == null && $downloadTotal != 0) {
                    // no progress bar and download started
                        
                    $this->bytesInPreviousIteration = 0; //
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
            },
        ]);

        $fileMd5Response = $client->request('GET', $linkMD5, [
            'auth' => [$this->credentials->login, $this->credentials->password],
            'sink' => "{$this->paths->get('system')->archive}/{$this->variableFolders}/{$filenameMD5}",
            'progress' => function ($downloadTotal, $downloadedBytes, $uploadTotal, $uploadedBytes) {
                if ($this->downloadProgressBar == null && $downloadTotal != 0) {
                    // no progress bar and download started
                        
                    $this->bytesInPreviousIteration = 0; //
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
            },
        ]);

        $this->line("");
    }

    private function md5Check($file)
    {

        $filename = basename($file);
        $md5Filename = $filename.".md5";
        $fileLocation = "{$this->paths->get('system')->archive}/{$this->variableFolders}/{$filename}";
        $md5FileLocation = "{$this->paths->get('storage')->archive}/{$this->variableFolders}/{$md5Filename}";

        $md5File = md5_file($fileLocation);
        $md5 = trim(substr(Storage::get($md5FileLocation), -33));

        if ($md5File == $md5) {
            $this->line("Checksum: ✅  passed!");
            Storage::delete($md5FileLocation);
            return true;
        } else {
            die("Checsum: ❌  failed! We'll have to quit, sorry!");
        }
    }
}
