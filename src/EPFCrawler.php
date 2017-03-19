<?php

namespace Atomescrochus\EPF;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Process\Process;

class EPFCrawler
{
    private $credentials;

    protected $currentFullUrl;
    protected $currentIncrementalUrl;
    protected $currentCrawlerUrl;
    protected $wgetSavePath;
    protected $epfFolderName;
    protected $currentIndexFileContent;
    protected $indexFileFolder;
    protected $currentIndexFolderName;

    public $links;
    public $fullImportTime;
    public $incrementalImportTime;

    /**
     * Create a new Skeleton Instance.
     */
    public function __construct($credentials)
    {
        $this->credentials = $credentials;
        $this->currentFullUrl = "https://feeds.itunes.apple.com/feeds/epf/v3/full/current/";
        $this->currentIncrementalUrl = "https://feeds.itunes.apple.com/feeds/epf/v3/full/current/incremental/current/";
        $this->epfFolderName = "epf-imports/";
        $this->currentIndexFolderName = "currentIndex";
        $this->wgetSavePath = storage_path("app/{$this->epfFolderName}/{$this->currentIndexFolderName}");
        $this->indexFileFolder = "{$this->epfFolderName}/currentIndex/";
        $this->links = collect([
            'full' => $this->getFullImportListOfFiles(),
            'incremental' => $this->getIncrementalImportListOfFiles(),
        ]);
    }

    private function getFullImportListOfFiles()
    {
        $this->crawlCurrentFolder();

        $crawler = new Crawler($this->currentIndexFileContent, $this->currentCrawlerUrl);
        $links = collect($crawler->filter('table > tr > td > a')->links());

        $links =  $links->reject(function ($link) {
            return str_contains($link->getUri(), 'incremental');
        })->map(function ($link) {
            return $link->getUri();
        });

        $this->fullImportTime = $this->getDateFromFilename($links->first());

        return $links;
    }

    private function getIncrementalImportListOfFiles()
    {
        $this->crawlCurrentFolder(true);

        $crawler = new Crawler($this->currentIndexFileContent, $this->currentCrawlerUrl);
        $links = collect($crawler->filter('table > tr > td > a')->links());

        $links = $links->map(function ($link) {
            return $link->getUri();
        });

        $this->incrementalImportTime = $this->getDateFromFilename($links->first());

        return $links;
    }

    private function getDateFromFilename($link)
    {
        $filename = basename($link, ".tbz");
        $time = str_replace("itunes", "", $filename);
        return Carbon::parse($time);
    }

    private function crawlCurrentFolder($incremental = false)
    {
        $this->currentCrawlerUrl = $incremental ? $this->currentIncrementalUrl : $this->currentFullUrl;
        
        $download = new Process("wget -c --user={$this->credentials->login} --password='{$this->credentials->password}' {$this->currentCrawlerUrl} -P {$this->wgetSavePath} --show-progress");

        $download->start();
        $download->wait();

        $currentIndexFileLocation = $this->indexFileFolder."index.html";
        $this->currentIndexFileContent = Storage::get($currentIndexFileLocation);
        Storage::delete($currentIndexFileLocation);
    }
}
