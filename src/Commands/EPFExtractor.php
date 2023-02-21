<?php

namespace Appwapp\EPF\Commands;

use Appwapp\EPF\Jobs\ExtractJob;
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

    /**
     * Start the extraction tasks.
     * 
     * @param array $toExtract
     *
     * @return void
     */
    public function startTasks(array $toExtract)
    {
        // Create the extraction directory
        Storage::makeDirectory($this->paths->get('storage')->extraction . "/{$this->variableFolders}");

        $toExtract = collect($toExtract);

        $toExtract = $toExtract->map(function ($file) {
            return $this->paths->get('system')->storage . $file;
        });

        $toExtract->each(function ($file) {
            $filename = basename($file);
            $this->line("Dispatching extraction of $filename...");
            ExtractJob::dispatch(
                $file,
                $this->group,
                $this->type,
                $this->option('delete') !== null || $this->confirm("Do you wish to delete the archive?")
            )->onQueue(config('apple-epf.queue'));
        });
    }
}
