<?php

namespace FELS\Entities;

class Admin extends \Illuminate\Foundation\Auth\User
{
    protected $table = 'admins';
    protected $hidden = ['password', 'remember_token'];
    protected $fillable = ['name', 'email', 'password'];

    /**
     * Encrypt password attribute of a user.
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
