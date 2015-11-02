<?php

namespace FELS\Core\Repository\Contracts;

interface Findable
{
    /**
     * Find a model instance by its id.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findById($id);

    /**
     * Find a model instance by its slug.
     *
     * @param $slug
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findBySlug($slug);
}
