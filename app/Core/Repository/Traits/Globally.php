<?php

namespace FELS\Core\Repository\Traits;

trait Globally
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

    /**
     * Delete model instances using their IDs.
     *
     * @param array $ids
     * @return int
     */
    public function destroyAll(array $ids)
    {
        return $this->model->destroy($ids);
    }
}
