<?php

namespace FELS\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use FELS\Entities\Traits\FollowableTrait;
use FELS\Exceptions\MethodNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements
    SluggableInterface,
    AuthorizableContract,
    AuthenticatableContract,
    CanResetPasswordContract
{
    use SoftDeletes,
        Authorizable,
        SluggableTrait,
        FollowableTrait,
        Authenticatable,
        CanResetPassword;

    protected $dates = ['deleted_at'];
    protected $casts = ['admin' => 'boolean', 'confirmed' => 'boolean'];
    protected $sluggable = ['build_from' => 'name', 'save_to' => 'slug'];
    protected $fillable = [
        'name', 'slug', 'email', 'password',
        'admin', 'confirmed', 'confirmation_code',
    ];
    protected $hidden = ['password', 'remember_token', 'confirmation_code'];

    /**
     * Associated lessons of a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * Associated activities of a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Push new activity for a user.
     *
     * @param $name
     * @param $related
     * @return mixed
     * @throws MethodNotFoundException
     */
    public function pushActivity($name, $related)
    {
        if (!method_exists($related, 'captureActivity')) {
            throw new MethodNotFoundException;
        }

        return $related->captureActivity($name);
    }

    /**
     * Check if a user is administrator or not.
     *
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * Check if a user's account has been activated or not.
     *
     * @return mixed
     */
    public function isActive()
    {
        return $this->confirmed;
    }

    /**
     * Encrypt password attribute of a user (mutator).
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Set the route key.
     *
     * @return string
     */
    public function getRouteKey()
    {
        return $this->slug;
    }
}
