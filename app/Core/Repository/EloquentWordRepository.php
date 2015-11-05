<?php

namespace FELS\Core\Repository;

use FELS\Entities\Word;
use FELS\Core\Repository\Traits\Findable;
use FELS\Core\Repository\Contracts\Paginatable;
use FELS\Core\Repository\Contracts\WordRepository;
use FELS\Core\Repository\Contracts\Findable as FindableContract;

class EloquentWordRepository implements
    Paginatable,
    WordRepository,
    FindableContract
{
    use Findable;

    protected $model;

    public function __construct(Word $model)
    {
        $this->model = $model;
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
        return $this->model->with('category', 'answers')
            ->oldest('content')->paginate($limit);
    }

    /**
     * Fetch learned words of a user in a specific category.
     *
     * @param $user
     * @param $category
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function fetchLearnedWords($user, $category)
    {
        return $user->words()->where('category_id', $category->id)
            ->learned()->paginate(15);
    }
}
