<?php

namespace FELS\Entities;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $table = 'words';
    protected $fillable = ['category_id', 'content'];

    /**
     * A word belongs to a specific category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * A word may have many answers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessonWord()
    {
        return $this->hasMany(LessonWord::class);
    }

    /**
     * Lessons that contain this word.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class)
            ->withPivot('answer_id', 'point')
            ->withTimestamps();
    }
}
