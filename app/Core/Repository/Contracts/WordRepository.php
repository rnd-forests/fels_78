<?php

namespace FELS\Core\Repository\Contracts;

interface WordRepository
{
    /**
     * Fetch learned words of a user in a specific category.
     *
     * @param $user
     * @param $category
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function fetchLearnedWords($user, $category);
}
