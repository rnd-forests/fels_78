<?php

namespace FELS\Core\Repository\Contracts;

interface CategoryRepository
{
    /**
     * Create a new model instance.
     *
     * @param array $data
     * @return static
     */
    public function create(array $data);

    /**
     * Update a model instance.
     *
     * @param array $data
     * @param $identifier
     * @return bool|int
     */
    public function update(array $data, $identifier);

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
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function first();

    /**
     * Filter words in a category.
     *
     * @param $user
     * @param $category
     * @param $type
     * @return mixed
     */
    public function filterWords($user, $category, $type);
}
