<?php

namespace FELS\Core\Repository\Contracts;

interface WordRepository
{
    /**
     * Update a word.
     *
     * @param array $data
     * @param $word
     * @return bool|int
     */
    public function update(array $data, $word);

    /**
     * Delete a word.
     *
     * @param $word
     * @return bool|null
     */
    public function delete($word);

    /**
     * Fetch learned words of a user in a specific category.
     *
     * @param $user
     * @param $category
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function fetchLearnedWords($user, $category);
}
