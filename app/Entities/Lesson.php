<?php

namespace FELS\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use FELS\Entities\Traits\CapturesActivity;
use FELS\Entities\Presenters\LessonPresenter;
use FELS\Entities\Traits\FlushRelatedActivities;

class Lesson extends Model
{
    use CapturesActivity,
        PresentableTrait,
        FlushRelatedActivities;

    protected $table = 'lessons';
    protected $dates = ['finished_at'];
    protected static $capturedEvents = [];
    protected $casts = ['finished' => 'boolean'];
    protected $presenter = LessonPresenter::class;
    protected $fillable = ['user_id', 'category_id', 'name', 'finished', 'finished_at'];

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
     * Generate URL to a lesson.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return route('categories.lessons.show', [$this->category, $this]);
    }

    /**
     * Get the total length of a lesson.
     *
     * @return int
     */
    public function getLengthAttribute()
    {
        return $this->isFinished()
            ? Carbon::parse($this->created_at)
                ->diffInSeconds(Carbon::parse($this->finished_at), true)
            : 0;
    }
}
