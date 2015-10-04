<?php

namespace FELS\Entities\Traits;

use FELS\Entities\Relationship;

trait FollowableTrait
{
    /**
     * The active relations between current user and other users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activeRelations()
    {
        return $this->hasMany(Relationship::class, 'follower_id');
    }

    /**
     * The list of users that are followed by current user.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function following()
    {
        $ids = $this->activeRelations->lists('followed_id')->toArray();

        return static::whereIn('id', $ids);
    }

    /**
     * The passive relations between current user and other users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function passiveRelations()
    {
        return $this->hasMany(Relationship::class, 'followed_id');
    }

    /**
     * The list of users that follow the current user.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function followers()
    {
        $ids = $this->passiveRelations->lists('follower_id')->toArray();

        return static::whereIn('id', $ids);
    }

    /**
     * Check if the current user is followed by another user.
     *
     * @param $anotherUser
     * @return bool
     */
    public function isFollowedBy($anotherUser)
    {
        $ids = $anotherUser->following()->lists('id')->toArray();

        return in_array($this->id, $ids);
    }

    /**
     * Check if the current user is following another user.
     *
     * @param $anotherUser
     * @return bool
     */
    public function isFollowing($anotherUser)
    {
        $ids = $anotherUser->followers()->lists('id')->toArray();

        return in_array($this->id, $ids);
    }
}