<?php

namespace Atomescrochus\EPF\Commands;

use Atomescrochus\EPF\EPFCrawler;
use Atomescrochus\EPF\Exceptions\MissingCommandOptions;
use Atomescrochus\EPF\Exceptions\NotSupported;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Process\Process;

class EPFImporter extends Command
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
    private $infos;
    private $infoFileLocation;
    private $fileDownloadLocation;
    private $downloadProgressBar;

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

        $this->downloadProgressBar = null;
        $this->infoFileLocation = "epf-imports/epfImportInfos.json";
        $this->fullPathToEpfImport = storage_path()."/app/epf-imports/";
        $this->storagePathToEpfImport = "/epf-imports/";
        $this->initInfoFile();
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

        $this->line("");
        $this->line("👋. Welcome to the Apple EPF importer! 👋");
        $this->info("The process of downloading and importing the files takes a lot of resources.");
        $this->info("The compressed files for a full import are over 30gb, and you still need space to uncompress them, and then import them to your database!");
        $this->comment("For your own sake, please make sure this is installed on a machine with enough resources!");

        if ($this->confirm("Other than that, you'll need patience and time. Do you want to continue?")) {
            $this->line("Allright then, grab a ☕, it's going to be a long ride!");

            $this->epf = new EPFCrawler($this->credentials);

            if ($this->option('type') == "full") {
                $this->startFullImportProcess();
            }

            if ($this->option('type') == "incremental") {
                $this->startIncrementalImportProcess();
            }

            if ($this->option('type') == "testing123") {
                $this->testProcess();
            }

            $this->writeInfoFile();

            $this->comment("We're done! Congratulations!");
        }
    }

    public function testProcess()
    {
        $this->line('');
        $this->line("🤖  Hello admin. We'll be starting a test with a limited set of files. You can always tweak stuff in the code, this is not intended for production use.");

        $processStarted = Carbon::now();
        
        $this->downloadFiles("incremental", true);

        // next things:
        // uncompress files
        // import files
        // delete files

        $processEnded = Carbon::now();

        $this->line("Test import process completed! 🎉");
        $this->info("Process started on: {$processStarted->toDatetimeString()}.");
        $this->info("Process ended on: {$processEnded->toDatetimeString()}.");
        $this->line("Duration in minutes: {$processStarted->diffInMinutes($processEnded)}.");
        $this->line("Duration in hours: {$processStarted->diffInHours($processEnded)}.");
        $this->line("");
    }

    private function startFullImportProcess()
    {
        $this->line('');
        $this->line("We're starting the process for a full import. Have you for your ☕ yet?");

        $processStarted = Carbon::now();
        $epfDate = $this->epf->fullImportTime;
        $shouldImport = is_null($this->infos->lastFullImportDate) ? true : $this->infos->lastFullImportDate->lte($epfDate);

        if ($shouldImport && $this->infos->lastFullImportComplete == false) {
            $this->info("Either your latest full import is not up to date, or the latest seems to not have been completed successfully. In any case, we have to download the files [again].");

            $this->infos->lastFullImportDate = $epfDate;
            $this->infos->lastFullImportComplete = false;
            $this->writeInfoFile();
            
            $this->downloadFiles("full");
        } else {
            $this->info("The latest full import you made is up to date, we won't be downloading the files again.");
        }

        // insert next things here after testing123 is done.

        // $this->infos->lastFullImportComplete = true; // should set true when EVERYTHING was finished correctly
        $this->writeInfoFile();
        $processEnded = Carbon::now();

        $this->line('');
        $this->line("Full import process completed! 🎉");
        $this->info("Process started on: {$processStarted->toDatetimeString()}.");
        $this->info("Process ended on: {$processEnded->toDatetimeString()}.");
        $this->line("Duration in minutes: {$processStarted->diffInMinutes($processEnded)}.");
        $this->line("Duration in hours: {$processStarted->diffInHours($processEnded)}.");
        $this->line("");
    }

    private function startIncrementalImportProcess()
    {
        $this->line('');
        $this->line("We're starting the process for an incremental import. Have you for your ☕ yet?");

        $processStarted = Carbon::now();
        $epfDate = $this->epf->incrementalImportTime;
        $shouldImport = is_null($this->infos->lastIncrementalImportDate) ? true : $this->infos->lastIncrementalImportDate->lte($epfDate);

        if ($shouldImport && $this->infos->lastIncrementalImportComplete == false) {
            $this->info("Either your latest incremental import is not up to date, or the latest seems to not have been completed successfully. In any case, we have to download the files [again].");

            $this->infos->lastIncrementalImportDate = $epfDate;
            $this->infos->lastIncrementalImportComplete = false;
            $this->writeInfoFile();
            
            $this->downloadFiles("incremental");
        } else {
            $this->info("The latest incremental import you made is up to date, we won't be downloading the files again.");
        }

        // insert next things here after testing123 is done.

        // $this->infos->lastFullImportComplete = true; // should set true when EVERYTHING was finished correctly
        $this->writeInfoFile();
        $processEnded = Carbon::now();

        $this->line('');
        $this->line("Incremental import process completed! 🎉");
        $this->info("Process started on: {$processStarted->toDatetimeString()}.");
        $this->info("Process ended on: {$processEnded->toDatetimeString()}.");
        $this->line("Duration in minutes: {$processStarted->diffInMinutes($processEnded)}.");
        $this->line("Duration in hours: {$processStarted->diffInHours($processEnded)}.");
        $this->line("");
    }

    private function downloadFiles($group, $debug = false)
    {
        $this->line("");
        $this->line("We're starting to download the '{$group}' group of files. Depending on your connection, this might take a long time!");

        $links = $this->epf->links->get($group);

        if ($debug) {
            $this->comment("⚠️  We're only getting the 'match' files, because this is a test! ⚠️ ");
            $links = $links->filter(function ($link) {
                return str_contains($link, 'match');
            });
        }

        $countLinks = count($links);

        $this->info("There is a total of {$countLinks} files to download.");

        $links->each(function ($link) use ($group) {
            $this->line("");
            $this->line("Starting download of {$link}");
            $this->line("");

            $this->executeDownload($link, $group);

            $this->line("");
            $this->line("Finished download of {$link}");
            $this->line("");
        });


        $this->line("Starting md5 checksum of downloaded files. 🏁");
        $this->line('');

        $md5ChecksFailed = $links->reject(function ($link) {
            return str_contains($link, ".md5");
        })->map(function ($link) {
            return basename($link);
        })->flatten()->mapWithKeys(function ($filename) use ($group) {
            $check = $this->verifyFileHash($filename, $group);
            return [$filename => $check];
        })->contains(false);

        if ($md5ChecksFailed) {
            if ($this->confirm("Some of the MD5 checks failed. Some files might be corrupted. You could continue (no) or abort and start over (yes). Do you want to abort?")) {
                die("Aborted. Catch you on the flip side.");
            }
        }
    }

    private function verifyFileHash($filename, $group)
    {

        $pathToFile = "{$this->storagePathToEpfImport}{$group}/{$filename}";
        $pathToMd5File = $pathToFile.".md5";
        $fileToCheck = "{$this->fullPathToEpfImport}{$group}/{$filename}";
        $fileToCheck = md5_file($fileToCheck);
        $md5StringAgainst = trim(substr(Storage::get($pathToMd5File), -33));
        
        if ($fileToCheck == $md5StringAgainst) {
            $this->line("{$filename} checksum: ✅ passed!");
            return true;
        } else {
            $this->line("{$filename} checksum: ❌ failed!");
            return false;
        }
    }

    private function executeDownload($link, $group)
    {
        $filename = $file = basename($link);
        $pathForStorage = "{$this->storagePathToEpfImport}/{$group}/{$filename}";
        $pathToSaveTo = "{$this->fullPathToEpfImport}{$group}/{$file}";
        
        Storage::put($pathForStorage, "");

        $client = new Client();
        $client->request('GET', $link, [
            'auth' => [$this->credentials->login, $this->credentials->password],
            'sink' => $pathToSaveTo,
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
    }

    private function writeInfoFile($where = null)
    {
        $toSave = clone $this->infos;
        
        $toSave->lastFullImportDate = $this->infos->lastFullImportDate->toDateString();
        $toSave->lastIncrementalImportDate = $this->infos->lastIncrementalImportDate->toDateString();
        
        Storage::put($this->infoFileLocation, json_encode($toSave));
    }

    private function initInfoFile()
    {
        if (Storage::exists($this->infoFileLocation)) {
            $this->infos = json_decode(Storage::get($this->infoFileLocation));
            $this->infos->lastFullImportDate = Carbon::parse($this->infos->lastFullImportDate);
            $this->infos->lastIncrementalImportDate = Carbon::parse($this->infos->lastIncrementalImportDate);
        } else {
            $content = (object) [
                'lastFullImportDate' => Carbon::now()->subDays(10), // anything in the past
                'lastIncrementalImportDate' => Carbon::now()->subDays(10), // anything in the past
                'lastIncrementalImportComplete' => false,
                'lastFullImportComplete' => false,
            ];

            $this->infos = $content;
        }
    }
}
