<?php

namespace FELS\Core\Repository;

use FELS\Entities\User;
use FELS\Entities\Activity;
use FELS\Core\Repository\Traits\Globally;
use FELS\Core\Repository\Contracts\Findable;
use FELS\Core\Repository\Contracts\Paginatable;
use FELS\Core\Repository\Contracts\UserRepository;
use FELS\Core\Repository\Traits\Findable as FindableTrait;

class EloquentUserRepository implements Findable, Paginatable, UserRepository
{
    use Globally, FindableTrait;

    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return \FELS\Entities\User
     */
    public function create(array $data)
    {
        return $this->model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'confirmation_code' => str_random(60) . $data['email'],
        ]);
    }

    /**
     * Restore a soft deleted user.
     *
     * @param $user
     * @return bool|null
     */
    public function restore($user)
    {
        return $user->restore();
    }

    /**
     * Soft delete a user.
     *
     * @param $user
     * @return bool|null
     */
    public function softDelete($user)
    {
        return $user->delete();
    }

    /**
     * Permanently delete a soft deleted user.
     *
     * @param $user
     * @return bool|null
     */
    public function forceDelete($user)
    {
        return $user->forceDelete();
    }

    /**
     * Find a user by slug with eager loaded relationships.
     *
     * @param $user
     * @return mixed
     * @return \FELS\Entities\User
     */
    public function loadRelations($user)
    {
        return $user->load('words', 'following', 'followers');
    }

    /**
     * Fetch paginated list of disabled users.
     *
     * @param $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function disabled($limit)
    {
        return $this->model->normal()->onlyTrashed()
            ->latest('deleted_at')->paginate($limit);
    }

    /**
     * Create a new user by administrator.
     *
     * @param array $data
     * @return \FELS\Entities\User
     */
    public function adminCreate(array $data)
    {
        return $this->model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'confirmed' => true,
        ]);
    }

    /**
     * Finding a user or creating a new user if the user does not exist.
     *
     * @param array $data
     * @return \FELS\Entities\User
     */
    public function findOrCreate(array $data)
    {
        return $this->model->firstOrCreate($data);
    }

    /**
     * Find a user by confirmation code.
     *
     * @param $code
     * @param bool|false $confirmed
     * @return \FELS\Entities\User
     */
    public function findPendingActivationAccount($code, $confirmed = false)
    {
        return $this->model->where('confirmation_code', $code)
            ->where('confirmed', $confirmed)->firstOrFail();
    }

    /**
     * Clear activation code of the user account.
     *
     * @param $user
     * @return bool
     */
    public function clearActivationCode($user)
    {
        return $user->update(['confirmation_code' => '', 'confirmed' => true]);
    }

    /**
     * Follow a user.
     *
     * @param $followedId
     * @param $user
     * @return \FELS\Entities\Relationship
     */
    public function createRelationship($followedId, $user)
    {
        $targetUser = $this->findById($followedId);
        if ($user->cannot('follow', $targetUser)) {
            abort(403);
        }

        return $user->activeRelations()->create(['followed_id' => $followedId]);
    }

    /**
     * Unfollow a user.
     *
     * @param $followedId
     * @param $user
     * @return bool|null
     */
    public function destroyRelationship($followedId, $user)
    {
        return $user->activeRelations()->where('followed_id', $followedId)
            ->firstOrFail()->delete();
    }

    /**
     * Get activity feed for a user.
     *
     * @param $user
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getActivityFeedFor($user)
    {
        return Activity::with('user', 'targetable')->whereIn('user_id', array_merge(
            $user->following()->pluck('followed_id')->toArray(),
            [$user->id]
        ))->latest()->paginate(20);
    }

    /**
     * Finding a user or creating a new user if the user does not exist.
     * Use for open authentication.
     *
     * @param array $userData
     * @param $authProvider
     * @return \FELS\Entities\User
     */
    public function oauthCreate(array $userData, $authProvider)
    {
        $user = $this->model->firstOrCreate($userData);
        $user->update([
            'auth_provider' => $authProvider,
            'confirmed' => true,
            'confirmation_code' => '',
        ]);

        return $user;
    }

    /**
     * Get the leaderboard (learned words of users).
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLeaderboard()
    {
        return $this->model->with('lessons', 'words')->where('learned_words', '>', 0)
            ->orderBy('learned_words', 'desc')->take(15)->get();
    }

    /**
     * Fetch all activities for a user.
     *
     * @param $user
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function fetchActivitiesFor($user)
    {
        return $user->activities()->with('user', 'targetable')->latest()->paginate(20);
    }

    /**
     * Paginate a collection of models.
     *
     * @param $limit
     * @param array|null $params
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($limit, array $params = null)
    {
        return $this->model->with('following', 'followers')
            ->normal()->paginate($limit);
    }
}
