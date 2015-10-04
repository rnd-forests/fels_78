<?php

namespace FELS\Entities;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
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
}