<?php

namespace FELS\Core\Repository\Contracts\Activity;

interface Globally
{
    /**
     * Get a collection of all model instances.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll();

    /**
     * Count the number of total instances.
     *
     * @return int
     */
    public function countAll();
}
