<?php

namespace FELS\Entities;

use Illuminate\Database\Eloquent\Model;
use FELS\Entities\Traits\SearchableTrait;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;

class Category extends Model implements SluggableInterface
{
    use SluggableTrait,
        SearchableTrait;

    protected $table = 'categories';
    protected $fillable = ['name', 'slug', 'description'];
    protected $sluggable = ['build_from' => 'name', 'save_to' => 'slug'];

    /**
     * A category may contain many lessons.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * A category may contain many words.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function words()
    {
        return $this->hasMany(Word::class);
    }

    /**
     * Unlearned words of a user in this category.
     *
     * @param $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function unlearnedWordsOf($user)
    {
        $ids = $user->getLearnedWordsIn($this)->lists('id')->toArray();

        return $this->words()->whereNotIn('id', $ids);
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
