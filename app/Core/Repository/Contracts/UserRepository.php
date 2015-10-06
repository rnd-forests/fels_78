<?php

namespace FELS\Core\Repository\Contracts;

interface UserRepository
{
    /**
     * Finding a user or creating a new user if the user does not exist.
     *
     * @param array $userData
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findOrCreate(array $userData);

    /**
     * Find a user by activation code.
     *
     * @param $code
     * @param bool|false $confirmed
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findByActivationCode($code, $confirmed = false);
}
