<?php

namespace FELS\Core\Search\Contracts;

interface Searchable
{
    /**
     * Process search request by administrator.
     *
     * @param $source
     * @param $pattern
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function adminSearch($source, $pattern);
}
