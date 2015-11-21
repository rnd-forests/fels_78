<?php

namespace FELS\Core\Repository;

use FELS\Entities\Answer;
use FELS\Core\Repository\Contracts\AnswerRepository;

class EloquentAnswerRepository implements AnswerRepository
{
    protected $model;

    public function __construct(Answer $model)
    {
        $this->model = $model;
    }

    /**
     * Update an answer.
     *
     * @param array $data
     * @param $answer
     * @return bool|int
     */
    public function update(array $data, $answer)
    {
        return $answer->update($data);
    }

    /**
     * Delete an answer.
     *
     * @param $answer
     * @return bool|null
     */
    public function delete($answer)
    {
        return $answer->delete();
    }
}
