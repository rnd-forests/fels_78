<?php

namespace FELS\Core\Repository;

use FELS\Entities\Answer;
use FELS\Core\Repository\Traits\Findable;
use FELS\Core\Repository\Contracts\AnswerRepository;
use FELS\Core\Repository\Contracts\Findable as FindableContract;

class EloquentAnswerRepository implements
    FindableContract,
    AnswerRepository
{
    use Findable;

    protected $model;

    public function __construct(Answer $model)
    {
        $this->model = $model;
    }
}
