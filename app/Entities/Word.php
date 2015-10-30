<?php

namespace FELS\Entities;

use Illuminate\Database\Eloquent\Model;
use FELS\Entities\Traits\SearchableTrait;

class Word extends Model
{
    use SearchableTrait;

    protected $table = 'words';
    protected $touches = ['category', 'lessons'];
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
    public function lessonWords()
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
            ->withPivot('answer_id', 'valid')
            ->withTimestamps();
    }

    /**
     * Query scope for learned word.
     *
     * @param $query
     * @return mixed
     */
    public function scopeLearned($query)
    {
        return $query->whereIn('words.id', function ($q) {
            $q->select('word_id')
                ->distinct()
                ->from('lesson_word')
                ->where('valid', true);
        });
    }

    /**
     * Query scope for unlearned word.
     *
     * @param $query
     * @return mixed
     */
    public function scopeUnlearned($query)
    {
        return $query->whereNotIn('words.id', function ($q) {
            $q->select('word_id')
                ->distinct()
                ->from('lesson_word')
                ->where('valid', true);
        });
    }

    /**
     * Sort words.
     *
     * @param $query
     * @return mixed
     */
    public function scopeAlphabetical($query)
    {
        return $query->orderBy('content', 'asc');
    }

    /**
     * Check if a word is learned by user in a specific lesson.
     *
     * @param $lesson
     * @return bool
     */
    public function isLearned($lesson)
    {
        return $lesson->learnedWords->contains($this);
    }
}
