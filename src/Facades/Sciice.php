<?php

/*
 * style: fix StyleCI.
 */

namespace Platform\Facades;

use Illuminate\Support\Facades\Facade;

class Sciice extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sciice';
    }
}
