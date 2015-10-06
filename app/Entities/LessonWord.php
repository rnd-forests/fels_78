<?php

namespace FELS\Entities;

use Illuminate\Database\Eloquent\Model;

class LessonWord extends Model
{
    protected $table = 'lesson_word';
    protected $fillable = ['point', 'lesson_id', 'word_id', 'answer_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function word()
    {
        return $this->belongsTo(Word::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }
}
