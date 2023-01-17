<?php

namespace Appwapp\EPF\Commands;

use Alchemy\Zippy\Zippy;
use Appwapp\EPF\Traits\FileStorage;
use Illuminate\Support\Facades\Storage;

class EPFExtractor extends EPFCommand
{
    use FileStorage;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'epf:extract
        {--type= : the type of import, either "full", or "incremental"}
        {--group= : the group of import, either "itunes", "match", "popularity" or "pricing"}
        {--file= : the file you want to extract, either "all" or the file path you want to extract}
        {--skip-confirm : skip the confirmation prompt}
        {--delete : delete the archive after extraction}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract the EPF files downloaded from epf:download.';

    private $paths;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->paths = $this->getEPFFilesPaths();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line("");
        $this->line("👋 Welcome to the Apple EPF extractor! 👋");

        // Get the group and type
        $this->gatherUserInput();

        // Get the list of downloaded archive files
        $listOfFiles    = Storage::files($this->paths->get('storage')->archive."/{$this->variableFolders}");
        $extractChoices = array_merge(['all'], $listOfFiles);
        if (count($extractChoices) === 1) {
            $this->error('Can\'t find files to extract, did you download the files first?');
            exit;
        }

        $toExtract = $this->option('file') ?? $this->choice('Which file do you want to extract?', $extractChoices, 0);
        $toExtract = $toExtract == "all" ? $listOfFiles : $toExtract;

        if ($this->option('skip-confirm') !== null || $this->confirm("Are you ready to launch the extraction process?")) {
            $this->startTasks($toExtract);
            $this->comment("We're done extracting!");
        }
    }

    public function startTasks($toExtract)
    {
        // Create the extraction directory
        Storage::makeDirectory($this->paths->get('storage')->extraction."/{$this->variableFolders}");

        $this->startExtractionProcess($toExtract);
    }

    public function startExtractionProcess($toExtract)
    {
        $toExtract = collect($toExtract);

        $toExtract = $toExtract->map(function ($file) {
            return $this->paths->get('system')->storage.$file;
        });

        $toExtract->each(function ($file) {
            $filename = basename($file);

            $this->line("");
            $this->line("Extracting {$filename}...");

            $extractor = Zippy::load();
            $archive   = $extractor->open($file, '.tar.bz2');
            $archive->extract($this->paths->get('system')->extraction."/{$this->variableFolders}");
            $this->info("Extraction of {$filename} completed.");

            if ($this->option('delete') !== null || $this->confirm("Do you wish to delete the archive?")) {
                Storage::delete($this->paths->get('storage')->archive."/{$this->variableFolders}/{$filename}");
                $this->info("{$filename} deleted.");
            }
        });
    }
}
