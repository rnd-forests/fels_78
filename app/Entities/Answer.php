<?php

namespace FELS\Entities;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';
    protected $touches = ['word'];
    protected $casts = ['correct' => 'boolean'];
    protected $fillable = ['word_id', 'solution', 'correct'];

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
     * Check if the answer is chosen by user in a specific lesson.
     *
     * @param $lesson
     * @param $word
     * @return bool
     */
    public function isChosen($lesson, $word)
    {
        return in_array(
            [$word->id, $this->getKey()],
            $lesson->lessonWords->map(function ($pivot) {
                return [$pivot->word_id, $pivot->answer_id];
            })->toArray()
        );
    }
}
