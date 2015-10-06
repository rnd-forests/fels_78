<?php

namespace FELS\Core\Repository\Traits;

trait GloballyTrait
{
    /**
     * Get a collection of all model instances.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * Count the number of total instances.
     *
     * @return int
     */
    public function countAll()
    {
        return $this->model->count();
    }
}
