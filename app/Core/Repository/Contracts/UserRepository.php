<?php

namespace FELS\Core\Repository\Contracts;

interface UserRepository
{
    /**
     * Create a new user.
     *
     * @param array $data
     * @return \FELS\Entities\User
     */
    public function create(array $data);

    /**
     * Restore a soft deleted user.
     *
     * @param $user
     * @return bool|null
     */
    public function restore($user);

    /**
     * Soft delete a user.
     *
     * @param $user
     * @return bool|null
     */
    public function softDelete($user);

    /**
     * Permanently delete a soft deleted user.
     *
     * @param $user
     * @return bool|null
     */
    public function forceDelete($user);

    /**
     * Find a user by slug with eager loaded relationships.
     *
     * @param $user
     * @return mixed
     * @return \FELS\Entities\User
     */
    public function loadRelations($user);

    /**
     * Fetch paginated list of disabled users.
     *
     * @param $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function disabled($limit);

    /**
     * Create a new user by administrator.
     *
     * @param array $data
     * @return \FELS\Entities\User
     */
    public function adminCreate(array $data);

    /**
     * Finding a user or creating a new user if the user does not exist.
     *
     * @param array $data
     * @return \FELS\Entities\User
     */
    public function findOrCreate(array $data);

    /**
     * Find a user by activation code.
     *
     * @param $code
     * @param bool|false $confirmed
     * @return \FELS\Entities\User
     */
    public function findPendingActivationAccount($code, $confirmed = false);

    /**
     * Clear activation code of the user account.
     *
     * @param $user
     * @return bool
     */
    public function clearActivationCode($user);

    /**
     * Follow a user.
     *
     * @param $followedId
     * @param $user
     * @return \FELS\Entities\Relationship
     */
    public function createRelationship($followedId, $user);

    /**
     * Unfollow a user.
     *
     * @param $followedId
     * @param $user
     * @return bool|null
     */
    public function destroyRelationship($followedId, $user);

    /**
     * Get activity feed for a user.
     *
     * @param $user
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getActivityFeedFor($user);

    /**
     * Finding a user or creating a new user if the user does not exist.
     * Use for open authentication.
     *
     * @param array $userData
     * @param $authProvider
     * @return \FELS\Entities\User
     */
    public function oauthCreate(array $userData, $authProvider);

    /**
     * Get the leaderboard (learned words of users).
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLeaderboard();

    /**
     * Fetch all activities for a user.
     *
     * @param $user
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function fetchActivitiesFor($user);
}
