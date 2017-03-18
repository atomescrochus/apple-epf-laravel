<?php

namespace Atomescrochus\EPF;

use Illuminate\Support\Facades\Facade;

class EPFFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'apple-epf';
    }
}
