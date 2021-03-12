<?php

namespace InfinitySolutions\Infura\Facades;

use Illuminate\Support\Facades\Facade;

class Infura extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'infura';
    }
}
