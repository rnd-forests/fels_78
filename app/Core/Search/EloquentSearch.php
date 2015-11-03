<?php

namespace FELS\Core\Search;

use FELS\Core\Search\Contracts\Searchable;

class EloquentSearch implements Searchable
{
    /**
     * Model base namespace.
     *
     * @var string
     */
    protected static $namespace = '\FELS\Entities\\';

    /**
     * Model attributes that are used to search.
     *
     * @var array
     */
    protected static $attributes = [
        'user' => 'name',
        'category' => 'name',
        'word' => 'content',
    ];

    /**
     * Process search request by administrator.
     *
     * @param $source
     * @param $pattern
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function adminSearch($source, $pattern)
    {
        $model = static::$namespace . ucfirst($source);

        return call_user_func_array(
            "{$model}::search",
            [static::$attributes[$source], $pattern]
        )->latest()->paginate(15);
    }
}
