<?php

namespace FELS\Core\Repository;

use FELS\Entities\Lesson;
use FELS\Entities\Category;
use FELS\Core\Repository\Traits\ShouldBeFoundTrait;
use FELS\Core\Repository\Contracts\LessonRepository;
use FELS\Core\Repository\Contracts\Activity\ShouldBeFound;

class EloquentLessonRepository implements
    ShouldBeFound,
    LessonRepository
{
    use ShouldBeFoundTrait;

    protected $model;

    public function __construct(Lesson $model)
    {
        $this->model = $model;
    }

    /**
     * Find a lesson that belongs to a category.
     *
     * @param $categorySlug
     * @param $lessonId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findLesson($categorySlug, $lessonId)
    {
        return Category::where('slug', $categorySlug)
            ->firstOrFail()
            ->lessons()
            ->firstOrNew(['id' => $lessonId]);
    }

    /**
     * Fetch lessons of a category that belong to a user.
     *
     * @param $user
     * @param $category
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function fetchLessons($user, $category)
    {
        return $user->lessons()
            ->where('category_id', $category->id)
            ->paginate(15);
    }
}
