<?php

namespace FELS\Core\Search\Facades;

use Illuminate\Support\Facades\Facade;

class SearchFacade extends Facade
{
    /**
     * Register search container binding key.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'search';
    }
}
