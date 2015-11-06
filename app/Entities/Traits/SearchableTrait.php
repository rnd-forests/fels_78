<?php

namespace FELS\Entities\Traits;

trait SearchableTrait
{
    /**
     * Search for model instances by according to a column.
     *
     * @param $query
     * @param $column
     * @param $pattern
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $column, $pattern)
    {
        return $query->where($column, 'like', "%$pattern%");
    }
}
