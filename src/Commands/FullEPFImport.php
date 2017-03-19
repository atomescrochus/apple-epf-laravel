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
    private $infos;
    private $infoFileLocation;
    private $fileDownloadLocation;
    private $progressBar;

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

        $this->progressBar = null;
        $this->infoFileLocation = "epf-imports/epfImportInfos.json";
        $this->fullImportfileDownloadLocationForFilesystem = "epf-imports/full/";
        $this->fullImportfileDownloadLocation = storage_path()."/app/epf-imports/full/";
        $this->incrementalImportfileDownloadLocation = storage_path()."/app/epf-imports/incremental/";
        $this->incrementalImportfileDownloadLocationForFilesystem = "epf-imports/incremental/";
        $this->initInfoFile();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line("");
        $this->comment("This might take a while, some of the files are huge.");
        $this->checkForType();
        
        $this->epf = new EPFCrawler($this->credentials);

        if ($this->type == "full") {
            $this->startFullImportProcess();
        }

        $this->writeInfoFile();
        $this->comment("We're done! Congratulations!");
    }

    private function startFullImportProcess()
    {
        $this->info("We've started the full import process, you can go take a ☕️!");
        $epfDate = $this->epf->fullImportTime;
        $shouldImport = is_null($this->infos->lastFullImportDate) ? true : $this->infos->lastFullImportDate->lte($epfDate);

        if ($shouldImport && $this->infos->lastFullImportComplete == false) {
            $this->comment("Either your latest full import is not up to date, or the latests seems to not have completed successfully. In any case, we'll be starting the process again, and resuming incomplete files.");

            $this->infos->lastFullImportDate = $epfDate;
            $this->infos->lastFullImportComplete = false;

            $this->writeInfoFile();
            $this->downloadFullFiles();
        } else {
            $this->comment("The latests full import you made is up to date, we won't download the files again.");
        }

        // $this->infos->lastFullImportComplete = true; should set true when also imported to database
        
        $this->writeInfoFile();
        $this->info("Full import process completed! 🎉");
    }

    private function downloadFullFiles()
    {
        $this->info("We've started to download the files. This can take a long time, as some files are huge (we're talking gigabytes huge) !");

        $links = $this->epf->links->get('full');

        $links->each(function ($link) {
            $this->line("");
            $this->info("Starting download of {$link}");
            
            $file = basename($link);
            $fileLocation = $this->fullImportfileDownloadLocation.$file;

            $client = new Client();
            $client->request('GET', $link, [
                'auth' => [$this->credentials->login, $this->credentials->password],
                'sink' => $fileLocation,
                'progress' => function ($downloadTotal, $downloadedBytes, $uploadTotal, $uploadedBytes) {
                    // $this->line("total: {$downloadTotal}");
                    // $this->line("downloaded: {$downloadedBytes}");
                    if ($this->progressBar == null && $downloadTotal != 0) {
                        $this->downloadedBefore = 0;
                        $this->progressBar = new ProgressBar($this->output, $downloadTotal);
                        $this->progressBar->setFormat('debug');
                    } else if ($this->progressBar != null && $downloadTotal == $downloadedBytes) {
                        $this->progressBar->finish();
                    } else if ($this->progressBar != null) {
                        $this->progressBar->advance($downloadedBytes - $this->downloadedBefore);
                        $this->downloadedBefore = $downloadedBytes;
                    }
                },
            ]);
            $this->progressBar = null;
            $this->line("");
        });
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
                'lastIncrementalmportComplete' => false,
                'lastFullImportComplete' => false,
            ];

            $this->infos = $content;
        }
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
