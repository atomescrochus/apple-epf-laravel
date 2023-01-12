<?php

namespace Appwapp\EPF\Commands;

use Appwapp\EPF\EPFFileImporter;
use Appwapp\EPF\Traits\FeedCredentials;
use Appwapp\EPF\Traits\FileStorage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class EPFImportToDatabase extends Command
{
    use FileStorage;
    use FeedCredentials;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'epf:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will help import data from files downloaded, then extracted, to database.';

    private $credentials;
    private $paths;

    private $type;
    private $group;
    private $folder;
    private $toExtract;
    private $variableFolders;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->credentials = $this->getCredentials();
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

        $this->type = $this->choice('What is the type of files you want to import?', ['full', 'incremental'], 0);
        $this->group = $this->choice('What is the group of files you want to import?', ['itunes', 'match', 'popularity', 'pricing'], 0);

        $this->variableFolders = "{$this->group}/{$this->type}";

        $this->askForFolder();
        $this->askForFile();

        if ($this->confirm("Are you ready to launch the importation process?")) {
            $this->startTasks();
            $this->comment("We're done extracting!");
        }
    }

    public function startTasks()
    {
        $this->toExtract->each(function ($file) {
            $this->info("Starting to processing {$file}");
            $pathToFile = $this->paths->get('system')->extraction."/{$this->variableFolders}/{$this->folder}/{$file}";

            $epfImport = new EPFFileImporter($pathToFile);
            $epfImport->startImport();

            $this->comment("Finished this file. I've imported or updated {$epfImport->totalRows} rows in {$epfImport->duration} seconds ⏱");

            if ($this->confirm("Would you like to deleted the file, now that it's been imported?")) {
                Storage::delete($this->paths->get('storage')->extraction."/{$this->variableFolders}/{$this->folder}/{$file}");
            }
        });
    }

    public function askForFolder()
    {
        $folderChoice = collect(Storage::directories($this->paths->get('storage')->extraction."/{$this->variableFolders}"))->map(function ($path) {

            $paths = collect(explode('/', $path));
            return $paths->last();
        })->toArray();

        if (count($folderChoice) == 0) {
            die("Can't find any directory for files with those choices, did you download and extract the files first?");
        }

        $this->folder = $this->choice('Of which folder do you wish to start the import?', $folderChoice, 0);
    }

    public function askForFile()
    {
        $listOfFiles = collect(Storage::files($this->paths->get('storage')->extraction."/{$this->variableFolders}/{$this->folder}"))->map(function ($path) {

            $paths = collect(explode('/', $path));
            return $paths->last();
        })->toArray();

        if (count($listOfFiles) == 0) {
            die("Can't find files for those choices, there was probably an error with the extraction or archive.");
        }

        $extractChoices = array_merge(['all'], $listOfFiles);

        $toExtract = $this->choice('Which file do you want to extract?', $extractChoices, 0);
        $this->toExtract = $toExtract == "all" ? $listOfFiles : $toExtract;
        $this->toExtract = collect($this->toExtract);
    }
}
