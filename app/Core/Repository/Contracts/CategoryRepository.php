<?php

namespace FELS\Core\Repository\Contracts;

interface CategoryRepository
{
    /**
     * Create a new category.
     *
     * @param array $data
     * @return \FELS\Entities\Category
     */
    public function create(array $data);

    /**
     * Update a category.
     *
     * @param array $data
     * @param $category
     * @return bool|int
     */
    public function update(array $data, $category);

    /**
     * Delete a category.
     *
     * @param $category
     * @return bool|null
     */
    public function delete($category);

    /**
     * Lists all categories by name and id.
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists();

    /**
     * Get the first match category.
     *
     * @param $key
     * @return \FELS\Entities\Category
     */
    public function findOrFirst($key);

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

    /**
     * Fetch all words in a category.
     *
     * @param $category
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function fetchWordsFor($category);
}
