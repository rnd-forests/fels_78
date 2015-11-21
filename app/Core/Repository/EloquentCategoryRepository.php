<?php

namespace FELS\Core\Repository;

use FELS\Entities\Word;
use FELS\Entities\Category;
use FELS\Core\Repository\Contracts\Findable;
use FELS\Core\Repository\Contracts\Paginatable;
use FELS\Core\Repository\Contracts\CategoryRepository;
use FELS\Core\Repository\Traits\Findable as FindableTrait;

class EloquentCategoryRepository implements Findable, Paginatable, CategoryRepository
{
    use FindableTrait;

    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    /**
     * Create a new category.
     *
     * @param array $data
     * @return \FELS\Entities\Category
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a category.
     *
     * @param array $data
     * @param $category
     * @return bool|int
     */
    public function update(array $data, $category)
    {
        return $category->update($data);
    }

    /**
     * Delete a category.
     *
     * @param $category
     * @return bool|null
     */
    public function delete($category)
    {
        return $category->delete();
    }

    /**
     * Lists all categories by name and id.
     *
     * @return \Illuminate\Support\Collection
     */
    public function lists()
    {
        return $this->model->oldest('name')->lists('name', 'id');
    }

    /**
     * Get the first match category.
     *
     * @param $key
     * @return Category
     */
    public function findOrFirst($key)
    {
        return is_null($key)
            ? $this->model->orderBy('name', 'asc')->firstOrFail()
            : $this->model->findOrFail($key);
    }

    /**
     * Filter words in a category.
     *
     * @param $user
     * @param $category
     * @param $type
     * @param $level
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public function filterWords($user, $category, $type, $level)
    {
        $baseQuery = null;

        switch ($type) {
            case Word::LEARNED:
                $baseQuery = $user->getLearnedWordsIn($category);
                break;
            case Word::UNLEARNED:
                $baseQuery = $category->unlearnedWordsOf($user);
                break;
            case Word::ALPHABET:
                $baseQuery = $category->words()->alphabetized();
                break;
        }

        return is_null($baseQuery) ? null : $level == Word::COMBINED
            ? $baseQuery->get()
            : $baseQuery->ofLevel($level)->get();
    }

    /**
     * Fetch all words in a category.
     *
     * @param $category
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function fetchWordsFor($category)
    {
        return $category->words()->with('category', 'answers')->alphabetized()->paginate(10);
    }

    /**
     * Paginate a collection of models.
     *
     * @param $limit
     * @param array|null $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($limit, array $params = null)
    {
        return $this->model->with('words')->latest()->paginate($limit);
    }
}
