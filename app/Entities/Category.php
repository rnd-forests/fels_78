<?php

namespace FELS\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;

class Category extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = ['build_from' => 'name', 'save_to' => 'slug'];
    protected $fillable = ['name', 'slug', 'description'];

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
     * Set the route key.
     *
     * @return string
     */
    public function getRouteKey()
    {
        return $this->slug;
    }
}
