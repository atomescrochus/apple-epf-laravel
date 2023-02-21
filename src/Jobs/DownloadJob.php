<?php

namespace Appwapp\EPF\Jobs;

use Appwapp\EPF\Traits\FeedCredentials;
use Appwapp\EPF\Traits\FileStorage;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DownloadJob implements ShouldQueue
{
    use Dispatchable, FeedCredentials, FileStorage, InteractsWithQueue, Queueable;

    /**
     * The EPF feed link to download.
     *
     * @var string
     */
    private string $link;

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
     * The variable folder path.
     *
     * @var string
     */
    private string $variableFolders;

    /**
     * The group the file is in.
     *
     * @var string
     */
    private string $group;

    /**
     * The type of EPF export.
     *
     * @var string
     */
    private string $type;

    /**
     * The downloaded file.
     *
     * @var string
     */
    private string $file;

    /**
     * Constructs a new instance.
     * 
     * @param  string  $link       The link to download the file from.
     * @param  string  $group      The group the file is in.
     * @param  string  $type       The type of EPF export.
     * @param  bool    $chainJobs  Wether or not to chain the next job.
     *
     * @return void
     */
    public function __construct(string $link, string $group, string $type)
    {
        $this->link            = $link;
        $this->credentials     = $this->getCredentials();
        $this->paths           = $this->getEPFFilesPaths();
        $this->group           = $group;
        $this->type            = $type;
        $this->variableFolders = "$group/$type";
    }

    /**
     * Handle the download job.
     *
     * @return void
     */
    public function handle ()
    {
        $this->download($this->link);
        $this->md5Check($this->link);
        
        // Chain the extract job
        if (config('apple-epf.chain_jobs')) {
            ExtractJob::dispatch($this->file, $this->group, $this->type)->onQueue(config('apple-epf.queue'));
        }
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
        $linkMd5     = sprintf('%s.md5', $link);
        $filename    = basename($link);
        $filenameMd5 = basename($linkMd5);
        
        // Make sure file exists for the sink to work
        Storage::put("{$this->paths->get('storage')->archive}/{$this->variableFolders}/{$filename}", "");
        Storage::put("{$this->paths->get('storage')->archive}/{$this->variableFolders}/{$filenameMd5}", "");
        
        $client = new Client();
        $client->request('GET', $link, [
            'auth' => [$this->credentials->login, $this->credentials->password],
            'sink' => "{$this->paths->get('system')->archive}/{$this->variableFolders}/{$filename}",
        ]);

        $client->request('GET', $linkMd5, [
            'auth' => [$this->credentials->login, $this->credentials->password],
            'sink' => "{$this->paths->get('system')->archive}/{$this->variableFolders}/{$filenameMd5}",
        ]);
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
        $md5     = trim(substr(Storage::get($md5FileLocation), -33));

        if ($md5File === $md5) {
            Log::debug("Checksum: ✅ passed! Deleting the .md5...");
            Storage::delete($md5FileLocation);
            $this->file = $fileLocation;
            return true;
        }
            
        Storage::delete($fileLocation);
        Storage::delete($md5FileLocation);

        throw new \Exception('Checsum: ❌ failed! Deleting both files!');
    }
}
