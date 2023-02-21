<?php

namespace Appwapp\EPF\Commands;

use Appwapp\EPF\Jobs\ImportJob;
use Appwapp\EPF\Traits\FileStorage;
use Illuminate\Support\Facades\Storage;

class EPFImportToDatabase extends EPFCommand
{
    use FileStorage;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'epf:import
        {--type= : the type of import, either "full", or "incremental"}
        {--group= : the group of import, either "itunes", "match", "popularity" or "pricing"}
        {--folder= : the folder name to import from, ex: "itunes20230115"}
        {--file= : the file to import or "all"}
        {--skip-confirm : skip the confirmation prompt}
        {--delete : deletes the file once imported}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will help import data from files downloaded, then extracted, to database.';

    /**
     * The paths.
     *
     * @var object
     */
    private $paths;

    /**
     * The folder to import from.
     *
     * @var string
     */
    private $folder;

    /**
     * The files to extract from.
     *
     * @var array
     */
    private $toExtract;

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
        $this->line("👋. Welcome to the Apple EPF importer! 👋");

        // Get the group and type of import
        $this->gatherUserInput();

        // Get the folder and file(s) to import
        $this->askForFolder();
        $this->askForFile();

        // Start the importation
        if ($this->option('skip-confirm') !== null || $this->confirm("Are you ready to launch the importation process?")) {
            $this->startTasks();
            $this->comment("We're done extracting!");
        }
    }

    /**
     * Starts the importation tasks.
     *
     * @return void
     */
    public function startTasks()
    {
        $this->toExtract->each(function ($file) {
            $this->info("Dispatching importation of {$file}");
            $pathToFile = $this->paths->get('system')->extraction."/{$this->variableFolders}/{$this->folder}/{$file}";
            ImportJob::dispatch(
                $pathToFile,
                $this->group,
                $this->type,
                $this->option('delete') ?? $this->confirm("Would you like to deleted the file, now that it's been imported?")
            )->onQueue(config('apple-epf.queue'));
        });
    }

    /**
     * Asks for which folder to import from.
     *
     * @return void
     */
    public function askForFolder()
    {
        // Get the folders
        $folderChoice = collect(Storage::directories($this->paths->get('storage')->extraction."/{$this->variableFolders}"))
            ->map(function ($path) {
                return collect(explode('/', $path))->last();
            })->toArray();

        if (count($folderChoice) === 0) {
            $this->error('Can\'t find any directory for files with those choices, did you download and extract the files first?');
            exit;
        }

        $this->folder = $this->option('folder') ?? $this->choice('Of which folder do you wish to start the import?', $folderChoice, 0);
    }

    /**
     * Asks for which file to import from.
     *
     * @return void
     */
    public function askForFile()
    {
        $listOfFiles = collect(Storage::files($this->paths->get('storage')->extraction."/{$this->variableFolders}/{$this->folder}"))
            ->map(function ($path) {
                return collect(explode('/', $path))->last();
            })->toArray();

        if (count($listOfFiles) === 0) {
            die("Can't find files for those choices, there was probably an error with the extraction or archive.");
        }

        $extractChoices = array_merge(['all'], $listOfFiles);

        $toExtract = $this->option('file') ?? $this->choice('Which file do you want to extract?', $extractChoices, 0);

        $this->toExtract = $toExtract == "all" ? $listOfFiles : $toExtract;
        $this->toExtract = collect($this->toExtract);
    }
}
