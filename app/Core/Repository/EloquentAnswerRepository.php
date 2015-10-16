<?php

namespace FELS\Core\Repository;

use FELS\Core\Repository\Traits\ShouldBeFoundTrait;
use FELS\Core\Repository\Contracts\AnswerRepository;
use FELS\Core\Repository\Contracts\Activity\ShouldBeFound;

class EloquentAnswerRepository implements
    ShouldBeFound,
    AnswerRepository
{
    use ShouldBeFoundTrait;
}
