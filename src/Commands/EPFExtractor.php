<?php

namespace Appwapp\EPF\Commands;

use Alchemy\Zippy\Zippy;
use Appwapp\EPF\Traits\FeedCredentials;
use Appwapp\EPF\Traits\FileStorage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class EPFExtractor extends Command
{
    use FeedCredentials, FileStorage;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'epf:extract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will help extract files downloaded from epf:download.';

    private $credentials;
    private $paths;

    private $type;
    private $group;
    private $md5ChecksFailed;
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
        $this->line("👋. Welcome to the Apple EPF extractor! 👋");

        $this->type = $this->choice('What is the type of files you want to extract?', ['full', 'incremental'], 0);
        $this->group = $this->choice('What is the group of files you want to extract?', ['itunes', 'match', 'popularity', 'pricing'], 0);

        $this->variableFolders = "{$this->group}/{$this->type}";

        $listOfFiles = Storage::files($this->paths->get('storage')->archive."/{$this->variableFolders}");
        $extractChoices = array_merge(['all'], $listOfFiles);

        if (count($extractChoices) == 1) {
            die("Can't find files for those choices, did you download the files first?");
        }

        $toExtract = $this->choice('Which file do you want to extract?', $extractChoices, 0);
        $toExtract = $toExtract == "all" ? $listOfFiles : $toExtract;

        if ($this->confirm("Are you ready to launch the extraction process?")) {
            $this->startTasks($toExtract);
            $this->comment("We're done extracting!");
        }
    }

    public function startTasks($toExtract)
    {
        $this->checkForExtractionFolder();
        $this->startExtractionProcess($toExtract);
    }

    public function checkForExtractionFolder()
    {
        Storage::makeDirectory($this->paths->get('storage')->extraction."/{$this->variableFolders}");
    }

    public function startExtractionProcess($toExtract)
    {
        $toExtract = collect($toExtract);

        $toExtract = $toExtract->map(function ($file) {
            return $this->paths->get('system')->storage.$file;
        });

        $toExtract->each(function ($file) {
            $filename = basename($file);

            $this->info("Extracting {$filename} ...");

            $extractor = Zippy::load();
            $archive = $extractor->open($file, '.tar.bz2');
            $archive->extract($this->paths->get('system')->extraction."/{$this->variableFolders}");

            if ($this->confirm("Extraction of {$filename} completed, do you wish to delete the archive?")) {
                Storage::delete($this->paths->get('storage')->archive."/{$this->variableFolders}/{$filename}");
            }
        });
    }
}
