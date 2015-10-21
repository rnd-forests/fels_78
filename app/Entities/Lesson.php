<?php

namespace FELS\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableTrait;
use FELS\Entities\Traits\FlushRelatedActivities;
use Cviebrock\EloquentSluggable\SluggableInterface;

class Lesson extends Model implements SluggableInterface
{
    use SluggableTrait,
        FlushRelatedActivities;

    protected $table = 'lessons';
    protected $fillable = ['user_id', 'category_id', 'name', 'slug'];
    protected $sluggable = ['build_from' => 'name', 'save_to' => 'slug'];

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
        return $this->belongsToMany(Word::class)
            ->withPivot('answer_id', 'point')
            ->withTimestamps();
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
