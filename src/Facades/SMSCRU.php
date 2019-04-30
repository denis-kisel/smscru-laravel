<?php

namespace DenisKisel\SMSCRU\Facades;

use Illuminate\Support\Facades\Facade;

class SMSCRU extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'smscru';
    }
}
