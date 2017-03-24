<?php

namespace Atomescrochus\EPF;

use Atomescrochus\EPF\Traits\FeedCredentials;
use Atomescrochus\EPF\Traits\FileStorage;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;

class EPFCrawler
{
    use FeedCredentials;
    use FileStorage;

    private $credentials;
    protected $currentIndexContent;
    protected $currentCrawlerUrl;

    protected $urlForFullImportFiles;
    protected $urlForIncrementalImportFiles;

    public $links;
    public $fullImportTime;
    public $incrementalImportTime;

    /**
     * Create a new Skeleton Instance.
     */
    public function __construct()
    {
        $this->credentials = $this->getCredentials();
        $this->paths = $this->getEPFFilesPaths();

        $this->urlForFullImportFiles = "https://feeds.itunes.apple.com/feeds/epf/v3/full/current/";
        $this->urlForIncrementalImportFiles = "https://feeds.itunes.apple.com/feeds/epf/v3/full/current/incremental/current/";

        $this->links = collect([
            'full' => $this->getFullImportListOfFiles(),
            'incremental' => $this->getIncrementalImportListOfFiles(),
        ]);

        $this->currentIndexContent = "";
        $this->credentials = "";
    }

    private function getFullImportListOfFiles()
    {
        $this->crawlCurrentFolder(false);

        $crawler = new Crawler($this->currentIndexContent, $this->urlForFullImportFiles);
        $links = collect($crawler->filter('table > tr > td > a')->links());

        $links =  $links->reject(function ($link) {
            return str_contains($link->getUri(), 'incremental');
        })->reject(function ($link) {
            return str_contains($link->getUri(), '.md5');
        })->map(function ($link) {
            return $link->getUri();
        });

        $this->fullImportTime = $this->getDateFromFilename($links->first());

        return $links;
    }

    private function getIncrementalImportListOfFiles()
    {
        $this->crawlCurrentFolder(true);

        $crawler = new Crawler($this->currentIndexContent, $this->urlForIncrementalImportFiles);
        $links = collect($crawler->filter('table > tr > td > a')->links());

        $links = $links->map(function ($link) {
            return $link->getUri();
        })->reject(function ($link) {
            return str_contains($link, '.md5');
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
        $currentCrawlerUrl = $incremental ? $this->urlForIncrementalImportFiles : $this->urlForFullImportFiles;

        Storage::put($this->paths->get('storage')->epf_folder."/index.html", "");

        $client = new Client();
        
        $client->request('GET', $currentCrawlerUrl, ['auth' => [$this->credentials->login, $this->credentials->password],'sink' => $this->paths->get('system')->epf_folder."/index.html"]);

        $filePath = $this->paths->get('storage')->epf_folder."/index.html";
        
        $this->currentIndexContent = Storage::get($filePath);
        Storage::delete($filePath);
    }
}
