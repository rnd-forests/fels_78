<?php

namespace FELS\Entities;

use Illuminate\Database\Eloquent\Model;
use FELS\Entities\Traits\SearchableTrait;
use Laracasts\Presenter\PresentableTrait;
use FELS\Entities\Presenters\WordPresenter;

class Word extends Model
{
    const HARD = 'hard';
    const MEDIUM = 'medium';
    const EASY = 'easy';
    const COMBINED = 'combined';
    const LEARNED = 'learned';
    const UNLEARNED = 'unlearned';
    const ALPHABET = 'alphabetized';

    use SearchableTrait,
        PresentableTrait;

    protected $table = 'words';
    protected $presenter = WordPresenter::class;
    protected $touches = ['category', 'lessons'];
    protected $fillable = ['category_id', 'content', 'level'];

    /**
     * All users that learned this word.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

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
     * @return \Illuminate\Database\Eloquent\Builder
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
     * @return \Illuminate\Database\Eloquent\Builder
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
     * Query scope for sorting words in alphabetical order.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAlphabetized($query)
    {
        return $query->orderBy('content', 'asc');
    }

    /**
     * Get word with a specified difficulty level.
     *
     * @param $query
     * @param $level
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfLevel($query, $level)
    {
        return $query->where('level', $level);
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

    /**
     * Get difficulty levels.
     *
     * @return array
     */
    public static function getLevels()
    {
        $levels = [self::HARD, self::MEDIUM, self::EASY];

        return array_combine($levels, $levels);
    }
}
