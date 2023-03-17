<?php

namespace Appwapp\EPF\Jobs;

use Appwapp\EPF\Traits\FileStorage;
use Alchemy\Zippy\Zippy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ExtractJob implements ShouldQueue
{
    use Dispatchable, FileStorage, InteractsWithQueue, Queueable;

    /**
     * The file to extract.
     *
     * @var string
     */
    private string $file;

    /**
     * The EPF local file paths.
     *
     * @var object
     */
    private object $paths;

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
     * The variable folder path.
     *
     * @var string
     */
    private string $variableFolders;

    /**
     * Wether if the file should be deleted or not.
     *
     * @var bool
     */
    private bool $shouldDelete;

    public function __construct(string $file, string $group, string $type, bool $shouldDelete = true)
    {
        $this->file            = $file;
        $this->paths           = $this->getEPFFilesPaths();
        $this->group           = $group;
        $this->type            = $type;
        $this->variableFolders = "$group/$type";
        $this->shouldDelete    = $shouldDelete;
    }

    public function handle()
    {
        $filename = basename($this->file);

        $extractor = Zippy::load();
        $archive   = $extractor->open($this->file, '.tar.bz2');

        Storage::makeDirectory($this->paths->get('storage')->extraction . "/{$this->variableFolders}");
        $archive->extract($this->paths->get('system')->extraction . "/{$this->variableFolders}");
        Log::debug("Extraction of {$filename} completed.");

        if ($this->shouldDelete) {
            Storage::delete($this->paths->get('storage')->archive . "/{$this->variableFolders}/{$filename}");
            Log::debug("{$filename} deleted.");
        }

        // Chain the import job
        if (config('apple-epf.chain_jobs')) {
            $extractedFilename = str_replace('.tbz', '', $filename);

            // Find the last extracted folder
            $folders         = collect(Storage::directories($this->paths->get('storage')->extraction . "/{$this->variableFolders}/"));
            $extractedFolder = basename($folders->last(fn ($folder) => str_contains($folder, $this->group)));

            // Dispatch the import job
            ImportJob::dispatch(
                $this->paths->get('system')->extraction . "/{$this->variableFolders}/$extractedFolder/$extractedFilename",
                $this->group,
                $this->type,
                $this->shouldDelete
            )->onQueue(config('apple-epf.queue'));
        }
    }
}
