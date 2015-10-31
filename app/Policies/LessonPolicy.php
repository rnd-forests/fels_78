<?php

namespace FELS\Policies;

use FELS\Entities\User;
use FELS\Entities\Lesson;
use Illuminate\Auth\Access\HandlesAuthorization;

class LessonPolicy
{
    use HandlesAuthorization;

    /**
     * Authorize to show a lesson.
     *
     * @param User $user
     * @param Lesson $lesson
     * @return bool
     */
    public function showLesson(User $user, Lesson $lesson)
    {
        return $user->id === $lesson->user->id;
    }

    /**
     * Authorize to view results of a lesson.
     *
     * @param User $user
     * @param Lesson $lesson
     * @return bool
     */
    public function showResults(User $user, Lesson $lesson)
    {
        return $user->id === $lesson->user->id && $lesson->isFinished();
    }
}
