<?php

namespace FELS\Entities;

use Illuminate\Database\Eloquent\Model;

class UserWord extends Model
{
    protected $table = 'user_word';
    protected $fillable = ['user_id', 'word_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function word()
    {
        return $this->belongsTo(Word::class);
    }
}
