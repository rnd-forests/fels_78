<?php

namespace FELS\Core\Search\Contracts;

interface SearchInterface
{
    /**
     * Process search request by administrator.
     *
     * @param $source
     * @param $pattern
     * @return mixed
     */
    public function adminSearch($source, $pattern);
}
