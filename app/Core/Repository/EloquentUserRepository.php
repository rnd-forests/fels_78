<?php

namespace FELS\Core\Repository;

use FELS\Entities\User;
use FELS\Entities\Activity;
use FELS\Core\Repository\Traits\Findable;
use FELS\Core\Repository\Traits\Globally;
use FELS\Core\Repository\Contracts\Paginatable;
use FELS\Core\Repository\Contracts\UserRepository;
use FELS\Core\Repository\Contracts\Findable as FindableContract;

class EloquentUserRepository implements
    Paginatable,
    UserRepository,
    FindableContract
{
    use Globally,
        Findable;

    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Create a new model instance.
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
     * Update a model instance.
     *
     * @param array $data
     * @param $slug
     * @return bool|int
     */
    public function update(array $data, $slug)
    {
        $user = $this->findBySlug($slug);

        return $user->update($data);
    }

    /**
     * Restore a soft deleted model instance.
     *
     * @param $slug
     * @return bool|null
     */
    public function restore($slug)
    {
        $user = $this->findSoftDeletedUser($slug);

        return $user->restore();
    }

    /**
     * Soft delete a model instance.
     *
     * @param $slug
     * @return bool|null
     */
    public function softDelete($slug)
    {
        $user = $this->findBySlug($slug);

        return $user->delete();
    }

    /**
     * Permanently delete a soft deleted model instance.
     *
     * @param $slug
     * @return bool|null
     */
    public function forceDelete($slug)
    {
        $user = $this->findSoftDeletedUser($slug);

        return $user->forceDelete();
    }

    /**
     * Find a user by slug with eager loaded relationships.
     *
     * @param $slug
     * @return mixed
     * @return \FELS\Entities\User
     */
    public function findBySlugWithRelations($slug)
    {
        return $this->model->with('words', 'following', 'followers')
            ->where('slug', $slug)->firstOrFail();
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
     * Add new user by administrator.
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
     * @param array $userData
     * @return \FELS\Entities\User
     */
    public function findOrCreate(array $userData)
    {
        return $this->model->firstOrCreate($userData);
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
     * Finding a soft deleted user.
     *
     * @param $slug
     * @return \FELS\Entities\User
     */
    public function findSoftDeletedUser($slug)
    {
        return $this->model->onlyTrashed()->where('slug', $slug)->firstOrFail();
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
            $user->following()->lists('followed_id')->toArray(),
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
}
