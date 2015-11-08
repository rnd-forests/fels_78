<?php

namespace FELS\Policies;

use FELS\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Authorize a user to follow another one.
     *
     * @param User $user
     * @param User $target
     * @return bool
     */
    public function follow(User $user, User $target)
    {
        return $user->id !== $target->id && ! $user->following->contains($target);
    }
}
