<?php

namespace FELS\Entities;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';
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
}
