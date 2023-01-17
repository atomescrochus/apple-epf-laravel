<?php

namespace Appwapp\EPF\Commands;

use Appwapp\EPF\Exceptions\MissingCommandOptions;
use Illuminate\Console\Command;

class EPFCommand extends Command
{
    /**
     * The supported import types.
     * 
     * @var array
     */
    public const SUPPORTED_TYPES = [
        'full',
        'incremental'
    ];

    /**
     * The supported import groups.
     *
     * @var array
     */
    public const SUPPORTED_GROUPS = [
        'itunes',
        'match',
        'popularity',
        'pricing'
    ];

    /**
     * The type of import to do.
     *
     * @var string
     */
    protected string $type;

    /**
     * The group to import.
     *
     * @var string
     */
    protected string $group;

    /**
     * The folder made of group and type.
     *
     * @var string
     */
    protected string $variableFolders;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Gather the user input.
     *
     * @return void
     */
    protected function gatherUserInput()
    {
        $optionType  = $this->option('type');
        $optionGroup = $this->option('group');

        if ($optionType !== null && ! in_array($optionType, self::SUPPORTED_TYPES)) {
            throw new MissingCommandOptions("The '$optionType' type is not supported.");
        }

        if ($optionGroup !== null && ! in_array($optionGroup, self::SUPPORTED_GROUPS)) {
            throw new MissingCommandOptions("The '$optionGroup' group is not supported.");
        }

        // Get the type and group
        $this->type  = $optionType ?? $this->choice('What is the type of files you want to download?', self::SUPPORTED_TYPES, 0);
        $this->group = $optionGroup ?? $this->choice('What is the group of files you want to download?', self::SUPPORTED_GROUPS, 0);

        // Build the varilable folder
        $this->variableFolders = "{$this->group}/{$this->type}";
    }
}
