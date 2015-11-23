<?php

namespace FELS\Core\Repository\Contracts;

interface AnswerRepository
{
    /**
     * Update an answer.
     *
     * @param array $data
     * @param $answer
     * @return bool|int
     */
    public function update(array $data, $answer);

    /**
     * Delete an answer.
     *
     * @param $answer
     * @return bool|null
     */
    public function delete($answer);
}
