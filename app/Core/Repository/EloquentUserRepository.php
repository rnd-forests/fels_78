<?php

namespace FELS\Core\Repository;

use FELS\Entities\User;
use FELS\Core\Repository\Traits\GloballyTrait;
use FELS\Core\Repository\Contracts\UserRepository;
use FELS\Core\Repository\Traits\ShouldBeFoundTrait;
use FELS\Core\Repository\Contracts\Activity\Globally;
use FELS\Core\Repository\Contracts\Activity\CanBeRemoved;
use FELS\Core\Repository\Contracts\Activity\CanBeCreated;
use FELS\Core\Repository\Contracts\Activity\CanBeUpdated;
use FELS\Core\Repository\Contracts\Activity\ShouldBeFound;

class EloquentUserRepository implements
    Globally,
    CanBeRemoved,
    CanBeCreated,
    CanBeUpdated,
    ShouldBeFound,
    UserRepository
{
    use GloballyTrait,
        ShouldBeFoundTrait;

    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
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
     * @param null $optionalIdentifier
     * @return bool|int
     */
    public function update(array $data, $identifier, $optionalIdentifier = null)
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
}
