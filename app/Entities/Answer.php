<?php

namespace FELS\Entities;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $casts = ['correct' => 'boolean'];
    protected $fillable = ['word_id', 'lesson_id', 'solution', 'correct'];

    /**
     * An answer belongs to a specific word.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function word()
    {
        return $this->belongsTo(Word::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessonWords()
    {
        return $this->hasMany(LessonWord::class);
    }
}