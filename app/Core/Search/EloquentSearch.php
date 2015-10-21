<?php

namespace FELS\Core\Search;

use FELS\Core\Search\Contracts\SearchInterface;

class EloquentSearch implements SearchInterface
{
    /**
     * Process search request by administrator.
     *
     * @param $source
     * @param $pattern
     * @return mixed
     */
    public function adminSearch($source, $pattern)
    {
        $columns = [
            'user' => 'name',
            'category' => 'name',
            'word' => 'content'
        ];
        $model = '\FELS\Entities\\' . ucfirst($source);
        return call_user_func_array($model . '::search', [$columns[$source], $pattern])
            ->latest()
            ->paginate(15);
    }
}
