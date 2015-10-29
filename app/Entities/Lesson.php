<?php

namespace FELS\Entities;

use Illuminate\Database\Eloquent\Model;
use FELS\Entities\Traits\CapturesActivity;
use FELS\Entities\Traits\FlushRelatedActivities;

class Lesson extends Model
{
    use CapturesActivity,
        FlushRelatedActivities;

    protected $table = 'lessons';
    protected static $capturedEvents = [];
    protected $casts = ['finished' => 'boolean'];
    protected $touches = ['user', 'category', 'words'];
    protected $fillable = ['user_id', 'category_id', 'name', 'finished'];

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
     * The words that belong to a lesson.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function words()
    {
        return $this->belongsToMany(Word::class)
            ->withPivot('answer_id', 'valid')
            ->withTimestamps();
    }

    /**
     * The learned words that belong to a lesson.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function learnedWords()
    {
        return $this->words()->wherePivot('valid', true);
    }

    /**
     * Query scope for finished lessons.
     *
     * @param $query
     * @return mixed
     */
    public function scopeFinished($query)
    {
        return $query->where('finished', true);
    }

    /**
     * Check if a lesson is finished or not.
     *
     * @return bool
     */
    public function isFinished()
    {
        return $this->finished;
    }

    /**
     * Lesson name attribute accessor.
     *
     * @param $name
     * @return string
     */
    public function getNameAttribute($name)
    {
        $parts = preg_split('/_/', $name);

        return "{$parts[0]} on @{$parts[1]} ({$this->created_at})";
    }

    /**
     * Generate URL to a lesson. If lesson is finished, we
     * route to result page, otherwise we route to show page.
     *
     * @return string
     */
    public function url()
    {
        return ($this->finished)
            ? route('categories.lessons.results', [$this->category, $this])
            : route('categories.lessons.show', [$this->category, $this]);
    }

    /**
     * Lesson created_at attribute accessor.
     *
     * @param $timestamp
     * @return string
     */
    public function getCreatedAtAttribute($timestamp)
    {
        return full_time($timestamp);
    }
}
