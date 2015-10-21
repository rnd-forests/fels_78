<?php

namespace FELS\Entities\Observers;

class UserObserver
{
    /**
     * Hook into user deleting event.
     *
     * @param User $user
     */
    public function deleting(User $user)
    {
        $user->activities()->delete();
        $user->activeRelations()->delete();
        $user->passiveRelations()->delete();
    }
}
