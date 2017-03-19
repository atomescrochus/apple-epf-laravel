<?php

namespace Atomescrochus\EPF\Exceptions;

use Exception;

class MissingCommandOptions extends Exception
{
    public static function type()
    {
        return new static('You must give the command an import type, either "full" or "incremental".');
    }
}
