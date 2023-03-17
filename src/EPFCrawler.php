<?php

namespace Appwapp\EPF;

use Appwapp\EPF\Traits\FeedCredentials;
use Appwapp\EPF\Traits\FileStorage;
use Illuminate\Support\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Collection;

class EPFCrawler
{
    use FeedCredentials, FileStorage;

    /**
     * Constants of types of feeds generated
     * on specific days of the week.
     *
     * @var int
     */
    public const
        FULL_FIRST_FEED_DAY         = 0,
        FULL_SECOND_FEED_DAY        = 6,
        INCREMENTAL_FIRST_FEED_DAY  = 2,
        INCREMENTAL_SECOND_FEED_DAY = 4;

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
     * URL for the incremental import from the latest full import.
     * @var string
     */
    protected string $urlForIncrementalImportFilesFromFull;

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
        $this->urlForFullImportFiles                = "https://feeds.itunes.apple.com/feeds/epf/v5/current/";
        $this->urlForIncrementalImportFiles         = "https://feeds.itunes.apple.com/feeds/epf/v5/current/incremental/current/";
        $this->urlForIncrementalImportFilesFromFull = "https://feeds.itunes.apple.com/feeds/epf/v5/%%date%%/incremental/current/";

        $this->links = collect([
            'full'        => collect($this->getFullImportListOfTypes()),
            'incremental' => collect($this->getIncrementalImportListOfTypes()),
        ]);

        $this->currentIndexContent = "";
    }

    /**
     * Gets a full import list per type.
     * i.e. itunes, match, popularity and pricing
     *
     * @return array
     */
    private function getFullImportListOfTypes(): array
    {
        $this->crawlFolder($this->urlForFullImportFiles);

        $types   = [];
        $crawler = new Crawler($this->currentIndexContent, $this->urlForFullImportFiles);
        $links   = collect($crawler->filter('table > tr > td > a')->links());
        $links   = $links->reject(function ($link) {
            return str_contains($link->getUri(), 'incremental');
        });

        // Get the links for each type
        foreach ($links as $link) {
            // Get the type name from link by removing the date
            $type = preg_replace('/[0-9]+|\//', '', $link->getNode()->nodeValue);

            // Get the links for that type
            $types[$type] = $this->getFullImportListOfFiles($link->getUri());
        }

        // Get the import time
        $this->fullImportTime = $this->getDateFromFilename($links->first()->getNode()->nodeValue);

        return $types;
    }

    /**
     * Gets a full import list of files from the EPF directory.
     * 
     * @param  string $url
     *
     * @return \Illuminate\Support\Collection
     */
    private function getFullImportListOfFiles(string $url): Collection
    {
        $this->crawlFolder($url);

        $crawler = new Crawler($this->currentIndexContent, $url);
        $links   = collect($crawler->filter('table > tr > td > a')->links());

        $links =  $links->reject(function ($link) {
            return str_contains($link->getUri(), 'incremental');
        })->reject(function ($link) {
            return str_contains($link->getUri(), '.md5');
        })->map(function ($link) {
            return $link->getUri();
        });        

        return $links;
    }

    /**
     * Gets the incremental import feed URL from the
     * last full import feed.
     *
     * @return string
     */
    private function getIncrementalUrlFromLastFullFeed()
    {
        // Depending on the day of the week, incremental import file
        // might not be in the current folder
        $date  = new Carbon();

        // Get the latest full feed date
        if (date('w') > self::FULL_FIRST_FEED_DAY) {
            $date->setDaysFromStartOfWeek(self::FULL_FIRST_FEED_DAY);
        } else {
            $date->week($date->week() - 1);
            $date->setDaysFromStartOfWeek(self::FULL_SECOND_FEED_DAY);
        }

        // Replace the date in the URL
        return str_replace('%%date%%', $date->format('Ymd'), $this->urlForIncrementalImportFilesFromFull);
    }

    /**
     * Gets a incremental import list per type.
     * i.e. itunes, match, popularity and pricing
     *
     * @throws ClientException
     * 
     * @return array
     */
    private function getIncrementalImportListOfTypes(): array
    {
        $url = $this->urlForIncrementalImportFiles;

        try {
            $this->crawlFolder($url);
        } catch (ClientException $exception) {
            // If anything else then not found, rethrow the error
            if ($exception->getResponse()->getStatusCode() !== 404) {
                throw $exception;
            }

            // If the current incremental feed is not ready, try the latest one from full feed
            $url = $this->getIncrementalUrlFromLastFullFeed();
            $this->crawlFolder($url);
        }

        $types   = [];
        $crawler = new Crawler($this->currentIndexContent, $url);
        $links   = collect($crawler->filter('table > tr > td > a')->links());

        foreach ($links as $link) {
            // Get the type name from link by removing the date
            $type = preg_replace('/[0-9]+|\//', '', $link->getNode()->nodeValue);

            // Get the links for that type
            $types[$type] = $this->getIncrementalImportListOfFiles($link->getUri());
        }

        // Get the import time
        $this->incrementalImportTime = $this->getDateFromFilename($links->first()->getNode()->nodeValue);

        return $types;
    }

    /**
     * Gets the incremental import list of files from the EPF directory.
     *
     * @param  string $url
     *
     * @return \Illuminate\Support\Collection
     */
    private function getIncrementalImportListOfFiles(string $url): Collection
    {
        $this->crawlFolder($url);

        $crawler = new Crawler($this->currentIndexContent, $url);
        $links = collect($crawler->filter('table > tr > td > a')->links());

        $links = $links->map(function ($link) {
            return $link->getUri();
        })->reject(function ($link) {
            return str_contains($link, '.md5');
        });

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
     * Crawl the folder.
     *
     * @param  string  $url  The remote url to crawl
     * 
     * @throws ClientException
     *
     * @return void
     */
    private function crawlFolder(string $url): void
    {
        $paths       = $this->getEPFFilesPaths();
        $credentials = $this->getCredentials();

        Storage::put($paths->get('storage')->epf_folder."/index.html", "");

        $client = new Client();
        $client->request('GET', $url, [
            'auth' => [$credentials->login, $credentials->password],
            'sink' => $paths->get('system')->epf_folder . '/index.html'
        ]);

        $filePath = $paths->get('storage')->epf_folder . '/index.html';
        
        $this->currentIndexContent = Storage::get($filePath);
        Storage::delete($filePath);
    }
}
