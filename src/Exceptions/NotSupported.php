<?php

namespace Atomescrochus\EPF\Exceptions;

use Exception;

class NotSupported extends Exception
{
    public static function incrementalImport()
    {
        return new static('Sorry, we are still not supporting the incremental import of the EPF feed.');
    }
}
