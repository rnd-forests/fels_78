<?php

namespace FELS\Core\Repository;

use FELS\Entities\Lesson;
use FELS\Entities\Category;
use FELS\Core\Repository\Traits\Globally;
use FELS\Core\Repository\Traits\Findable;
use FELS\Core\Repository\Contracts\LessonRepository;
use FELS\Core\Repository\Contracts\Findable as FindableContract;

class EloquentLessonRepository implements
    FindableContract,
    LessonRepository
{
    use Findable,
        Globally;

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
     * @return \FELS\Entities\Lesson
     */
    public function findLesson($categorySlug, $lessonId)
    {
        return Category::where('slug', $categorySlug)
            ->firstOrFail()->lessons()->firstOrNew(['id' => $lessonId]);
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
        return $user->lessons()->where('category_id', $category->id)->paginate(15);
    }

    /**
     * Fetch unprocessed lessons that have lifetime greater than
     * a predefined time interval (the default is 7 days).
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fetchUnprocessedLessons()
    {
        return $this->model->unfinished()->get()->filter(function ($lesson) {
            return $lesson->lifetime > config('lesson.max_unprocessed_time');
        });
    }
}
