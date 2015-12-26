<?php

namespace FELS\Entities;

use BadMethodCallException;
use FELS\Entities\Traits\FollowableTrait;
use Laracasts\Presenter\PresentableTrait;
use FELS\Entities\Traits\SearchableTrait;
use FELS\Entities\Presenters\UserPresenter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\SluggableTrait;
use FELS\Entities\Traits\FlushRelatedActivities;
use Cviebrock\EloquentSluggable\SluggableInterface;

class User extends \Illuminate\Foundation\Auth\User implements SluggableInterface
{
    use SoftDeletes,
        SluggableTrait,
        FollowableTrait,
        SearchableTrait,
        PresentableTrait,
        FlushRelatedActivities;

    protected $table = 'users';
    protected $dates = ['deleted_at'];
    protected $presenter = UserPresenter::class;
    protected $casts = ['confirmed' => 'boolean'];
    protected $sluggable = ['build_from' => 'name', 'save_to' => 'slug'];
    protected $hidden = ['password', 'remember_token', 'confirmation_code'];
    protected $fillable = [
        'name', 'slug', 'email', 'password', 'learned_words',
        'confirmed', 'confirmation_code', 'avatar',
        'auth_provider', 'facebook', 'github', 'google',
    ];

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
     * All learned words from lessons of a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function words()
    {
        return $this->belongsToMany(Word::class)->withTimestamps();
    }

    /**
     * Check if a user's account has been activated or not.
     *
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * Get learned words of a user in a category.
     *
     * @param $category
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getLearnedWordsIn($category)
    {
        return $this->words()->alphabetized()->where('category_id', $category->id);
    }

    /**
     * Push new activity for a user.
     *
     * @param $name
     * @param $relatedEntity
     * @return \FELS\Entities\Activity
     * @throws BadMethodCallException
     */
    public function pushActivity($name, $relatedEntity)
    {
        if (!method_exists($relatedEntity, 'captureActivity')) {
            throw new BadMethodCallException;
        }

        return $relatedEntity->captureActivity($name);
    }

    /**
     * Check the identity of two users.
     *
     * @param $user
     * @return bool
     */
    public function is($user)
    {
        return $user->id === $this->getKey();
    }

    /**
     * Encrypt password attribute of a user.
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Convert email to lowercase before saving into the database.
     *
     * @param $email
     */
    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }

    /**
     * Get ranking attribute of the user.
     *
     * @return string
     */
    public function getRankingAttribute()
    {
        $rank = $this->newQuery()->where('learned_words', '>=', counting($this->words));

        return "{$rank->count()} / {$this->count()}";
    }

    /**
     * Set the route key.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
