<?php

namespace FELS\Core\Repository;

use FELS\Entities\Answer;
use FELS\Core\Repository\Traits\ShouldBeFoundTrait;
use FELS\Core\Repository\Contracts\AnswerRepository;
use FELS\Core\Repository\Contracts\Activity\ShouldBeFound;

class EloquentAnswerRepository implements
    ShouldBeFound,
    AnswerRepository
{
    use ShouldBeFoundTrait;

    protected $model;

    public function __construct(Answer $model)
    {
        $this->model = $model;
    }
}
