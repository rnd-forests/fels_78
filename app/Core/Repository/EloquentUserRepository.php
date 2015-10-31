<?php

namespace FELS\Core\Repository;

use FELS\Entities\User;
use FELS\Entities\Activity;
use FELS\Core\Repository\Traits\GloballyTrait;
use FELS\Core\Repository\Contracts\UserRepository;
use FELS\Core\Repository\Traits\ShouldBeFoundTrait;
use FELS\Core\Repository\Contracts\Activity\Globally;
use FELS\Core\Repository\Contracts\Activity\CanBeRemoved;
use FELS\Core\Repository\Contracts\Activity\CanBeCreated;
use FELS\Core\Repository\Contracts\Activity\CanBeUpdated;
use FELS\Core\Repository\Contracts\Activity\ShouldBeFound;
use FELS\Core\Repository\Contracts\Activity\ShouldBePaginated;

class EloquentUserRepository implements
    Globally,
    CanBeRemoved,
    CanBeCreated,
    CanBeUpdated,
    ShouldBeFound,
    UserRepository,
    ShouldBePaginated
{
    use GloballyTrait,
        ShouldBeFoundTrait;

    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Find a user by slug with eager loaded relationships.
     *
     * @param $slug
     * @return mixed
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findBySlugWithRelations($slug)
    {
        return $this->model
            ->with('words', 'following', 'followers')
            ->where('slug', $slug)
            ->firstOrFail();
    }

    /**
     * Fetch paginated list of disabled users.
     *
     * @param $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function disabled($limit)
    {
        return $this->model
            ->normal()
            ->onlyTrashed()
            ->latest('deleted_at')
            ->paginate($limit);
    }

    /**
     * Add new user by administrator.
     *
     * @param array $data
     * @return mixed
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
     * @return \Illuminate\Database\Eloquent\Model
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
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findByActivationCode($code, $confirmed = false)
    {
        return $this->model
            ->where('confirmation_code', $code)
            ->where('confirmed', $confirmed)
            ->firstOrFail();
    }

    /**
     * Create a new model instance.
     *
     * @param array $data
     * @return static
     */
    public function create(array $data)
    {
        return $this->model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'confirmation_code' => str_random(100),
        ]);
    }

    /**
     * Update a model instance.
     *
     * @param array $data
     * @param $identifier
     * @return bool|int
     */
    public function update(array $data, $identifier)
    {
        $user = $this->findBySlug($identifier);

        return $user->update($data);
    }

    /**
     * Restore a soft deleted model instance.
     *
     * @param $identifier
     * @return bool|null
     */
    public function restore($identifier)
    {
        $user = $this->findSoftDeletedUser($identifier);
        $user->restore();
    }

    /**
     * Soft delete a model instance.
     *
     * @param $identifier
     * @return bool|null
     */
    public function softDelete($identifier)
    {
        $user = $this->findBySlug($identifier);
        $user->delete();
    }

    /**
     * Permanently delete a soft deleted model instance.
     *
     * @param $identifier
     * @return void
     */
    public function forceDelete($identifier)
    {
        $user = $this->findSoftDeletedUser($identifier);
        $user->forceDelete();
    }

    /**
     * Finding a soft deleted user.
     *
     * @param $slug
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findSoftDeletedUser($slug)
    {
        return $this->model
            ->onlyTrashed()
            ->where('slug', $slug)
            ->firstOrFail();
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
        return $this->model
            ->with('following', 'followers')
            ->normal()
            ->paginate($limit);
    }

    /**
     * Follow a user.
     *
     * @param $followedId
     * @param $user
     * @return mixed
     */
    public function createRelationship($followedId, $user)
    {
        $targetUser = $this->findById($followedId);
        if ($user->cannot('follow', $targetUser)) {
            abort(403);
        }

        return $user->activeRelations()
            ->create(['followed_id' => $followedId]);
    }

    /**
     * Unfollow a user.
     *
     * @param $followedId
     * @param $user
     * @return mixed
     */
    public function destroyRelationship($followedId, $user)
    {
        $relation = $user->activeRelations()
            ->where('followed_id', $followedId)
            ->firstOrFail();

        return $relation->delete();
    }

    /**
     * Get activity feed for a user.
     *
     * @param $user
     * @return mixed
     */
    public function getActivityFeedFor($user)
    {
        return Activity::whereIn('user_id', array_merge(
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
     * @return \Illuminate\Database\Eloquent\Model
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
}
