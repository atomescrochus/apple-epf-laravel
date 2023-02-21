<?php

namespace Appwapp\EPF\Jobs;

use Appwapp\EPF\EPFFileImporter;
use Appwapp\EPF\Traits\FileStorage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImportJob implements ShouldQueue
{
    use Dispatchable, FileStorage, InteractsWithQueue, Queueable;

    /**
     * The file to import.
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
     * The variable folder path.
     *
     * @var string
     */
    private string $variableFolders;

    /**
     * The EPF group.
     *
     * @var string
     */
    private string $group;

    /**
     * Wether if the file should be deleted or not.
     *
     * @var bool
     */
    private bool $shouldDelete;

    /**
     * Constructs a new instance.
     * 
     * @param string $file
     * @param string $group
     * @param bool   $shouldDelete
     */
    public function __construct(string $file, string $group, string $type, bool $shouldDelete = true)
    {
        $this->file            = $file;
        $this->group           = $group;
        $this->shouldDelete    = $shouldDelete;
        $this->variableFolders = "$group/$type";
        $this->paths           = $this->getEPFFilesPaths();
    }

    /**
     * Handle the import job.
     *
     * @return void
     */
    public function handle()
    {
        $fileName  = basename($this->file);
        $epfImport = new EPFFileImporter($this->file, $this->group);
        $epfImport->startImport();

        if ($epfImport->skipped) {
            Log::debug("Skipped $fileName.");
        } else {
            Log::debug("Finished $fileName. I've imported or updated {$epfImport->totalRows} rows in {$epfImport->duration} seconds ⏱");
        }

        if ($this->shouldDelete) {
            Storage::delete($this->file);
        }
    }
}
