<?php

namespace FELS\Core\Repository;

use FELS\Entities\Word;
use FELS\Entities\Category;
use FELS\Core\Repository\Traits\Findable;
use FELS\Core\Repository\Contracts\Paginatable;
use FELS\Core\Repository\Contracts\CategoryRepository;
use FELS\Core\Repository\Contracts\Findable as FindableContract;

class EloquentCategoryRepository implements
    Paginatable,
    FindableContract,
    CategoryRepository
{
    use Findable;

    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    /**
     * Create a new model instance.
     *
     * @param array $data
     * @return \FELS\Entities\Category
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a model instance.
     *
     * @param array $data
     * @param $slug
     * @return bool|int
     */
    public function update(array $data, $slug)
    {
        $category = $this->findBySlug($slug);

        return $category->update($data);
    }

    /**
     * Delete a category.
     *
     * @param $slug
     * @return bool|null
     */
    public function delete($slug)
    {
        $category = $this->findBySlug($slug);

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
     * @return \FELS\Entities\Category
     */
    public function first()
    {
        return $this->model->orderBy('name', 'asc')->firstOrFail();
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

        if ($baseQuery) {
            return $level == Word::COMBINED
                ? $baseQuery->get()
                : $baseQuery->ofLevel($level)->get();
        }

        return null;
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

    /**
     * Fetch all words in a category.
     *
     * @param $category
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function fetchWordsIn($category)
    {
        return $category->words()->with('category', 'answers')->alphabetized()->paginate(10);
    }
}
