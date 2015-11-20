<?php

namespace FELS\Core\Repository\Contracts;

interface LessonRepository
{
    /**
     * Find a lesson that belongs to a category.
     *
     * @param $categorySlug
     * @param $lessonId
     * @return \FELS\Entities\Lesson
     */
    public function findLesson($categorySlug, $lessonId);

    /**
     * Fetch lessons of a category that belong to a user.
     *
     * @param $user
     * @param $category
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function fetchLessons($user, $category);

    /**
     * Fetch unprocessed lessons that have lifetime greater than
     * a predefined time interval (the default is 7 days).
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fetchUnprocessedLessons();
}
