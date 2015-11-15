<?php

namespace FELS\Core\Repository\Contracts;

interface CategoryRepository
{
    /**
     * Create a new model instance.
     *
     * @param array $data
     * @return \FELS\Entities\Category
     */
    public function create(array $data);

    /**
     * Update a model instance.
     *
     * @param array $data
     * @param $slug
     * @return bool|int
     */
    public function update(array $data, $slug);

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

    /**
     * Get the first match category.
     *
     * @return \FELS\Entities\Category
     */
    public function first();

    /**
     * Filter words in a category.
     *
     * @param $user
     * @param $category
     * @param $type
     * @param $level
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function filterWords($user, $category, $type, $level);
}
