<?php

namespace FELS\Core\Repository\Contracts\Activity;

interface CanBeCreated
{
    /**
     * Create a new model instance.
     *
     * @param array $data
     * @return static
     */
    public function create(array $data);
}
