<?php

namespace FELS\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Cviebrock\EloquentSluggable\SluggableInterface;

class Lesson extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = ['build_from' => 'name', 'save_to' => 'slug'];
    protected $fillable = ['user_id', 'category_id', 'name', 'slug', 'description'];

    /**
     * A lesson belongs to a specific user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A lesson belongs to a specific category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessonWords()
    {
        return $this->hasMany(LessonWord::class);
    }

    /**
     * The words that belong to lesson.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function words()
    {
        $ids = $this->lessonWords()->lists('word_id')->toArray();
        
        return Word::whereIn('id', $ids);
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