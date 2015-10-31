<?php

namespace FELS\Entities\Observers;

use FELS\Entities\User;

class UserObserver
{
    /**
     * Hook into user deleting event.
     *
     * @param User $user
     */
    public function deleting(User $user)
    {
        $user->words()->detach();
        $user->lessons->each(function ($lesson) {
            $lesson->delete();
        });
        $user->activities()->delete();
        $user->activeRelations()->delete();
        $user->passiveRelations()->delete();
    }
}
