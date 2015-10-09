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
}
