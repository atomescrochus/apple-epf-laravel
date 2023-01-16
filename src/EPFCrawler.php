<?php

namespace Appwapp\EPF;

use Appwapp\EPF\Traits\FeedCredentials;
use Appwapp\EPF\Traits\FileStorage;
use Illuminate\Support\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Collection;

class EPFCrawler
{
    use FeedCredentials, FileStorage;

    /**
     * The index of the current content.
     *
     * @var mixed
     */
    protected $currentIndexContent;

    /**
     * The URL of the current crawled content.
     *
     * @var string
     */
    protected string $currentCrawlerUrl;

    /**
     * URL for the full import.
     * @var mixed
     */
    protected string $urlForFullImportFiles;

    /**
     * URL for the incremental import.
     * @var string
     */
    protected string $urlForIncrementalImportFiles;

    /**
     * All the links to crawl for.
     *
     * @var Collection
     */
    public Collection $links;

    /**
     * The time of the full import.
     *
     * @var Carbon
     */
    public Carbon $fullImportTime;

    /**
     * The time of the incremental import.
     *
     * @var Carbon
     */
    public Carbon $incrementalImportTime;

    /**
     * Construct a new instance.
     */
    public function __construct()
    {
        $this->urlForFullImportFiles        = "https://feeds.itunes.apple.com/feeds/epf/v5/current/";
        $this->urlForIncrementalImportFiles = "https://feeds.itunes.apple.com/feeds/epf/v5/current/incremental/current/";

        $this->links = collect([
            'full'        => $this->getFullImportListOfFiles(),
            'incremental' => $this->getIncrementalImportListOfFiles(),
        ]);

        $this->currentIndexContent = "";
    }

    /**
     * Gets a full import list of files from the EPF directory.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getFullImportListOfFiles(): Collection
    {
        $this->crawlCurrentFolder(false);

        $crawler = new Crawler($this->currentIndexContent, $this->urlForFullImportFiles);
        $links   = collect($crawler->filter('table > tr > td > a')->links());

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

    /**
     * Gets the incremental import list of files from the EPF directory.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getIncrementalImportListOfFiles(): Collection
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

    /**
     * Gets the date from the import filename.
     *
     * @param  string $link
     *
     * @return Carbon
     */
    private function getDateFromFilename(string $link): Carbon
    {
        $filename = basename($link, ".tbz");
        $time = str_replace("itunes", "", $filename);
        return Carbon::parse($time);
    }

    /**
     * Crawl the current folder.
     *
     * @param bool $incremental
     *
     * @return void
     */
    private function crawlCurrentFolder(bool $incremental = false): void
    {
        $paths             = $this->getEPFFilesPaths();
        $credentials       = $this->getCredentials();
        $currentCrawlerUrl = $incremental ? $this->urlForIncrementalImportFiles : $this->urlForFullImportFiles;

        Storage::put($paths->get('storage')->epf_folder."/index.html", "");

        $client = new Client();
        $client->request('GET', $currentCrawlerUrl, [
            'auth' => [$credentials->login, $credentials->password],
            'sink' => $paths->get('system')->epf_folder . '/index.html'
        ]);

        $filePath = $paths->get('storage')->epf_folder . '/index.html';
        
        $this->currentIndexContent = Storage::get($filePath);
        Storage::delete($filePath);
    }
}
