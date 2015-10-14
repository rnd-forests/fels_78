<?php

namespace FELS\Core\Repository\Contracts;

interface CategoryRepository
{
    /**
     * Delete a category.
     *
     * @param $slug
     * @return bool|null
     */
    public function delete($slug);

    /**
     * Lists all categories by name and id.
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists();
}
