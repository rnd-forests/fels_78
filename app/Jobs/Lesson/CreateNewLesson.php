<?php

namespace FELS\Jobs\Lesson;

use FELS\Jobs\Job;
use FELS\Entities\Word;
use FELS\Entities\Lesson;
use FELS\Core\Repository\Contracts\CategoryRepository;

class CreateNewLesson extends Job
{
    protected $user;
    protected $category;
    protected $lessonType;

    public function __construct($user, $categoryId, $lessonType)
    {
        $this->user = $user;
        $this->category = app(CategoryRepository::class)->findById($categoryId);
        $this->lessonType = $lessonType;
    }

    /**
     * Create a new lesson.
     *
     * @return bool
     */
    public function handle()
    {
        return $this->hasEnoughWords() ? $this->buildLessonRelations() : false;
    }

    /**
     * Fill in possible attributes for the lesson.
     *
     * @return Lesson
     */
    protected function buildLesson()
    {
        return (new Lesson)->fill([
            'name' => uniqid("Lesson_{$this->category->name}_"),
            'finished' => false,
            'type' => $this->lessonType,
        ]);
    }

    /**
     * Build lesson relationships.
     *
     * @return array
     */
    protected function buildLessonRelations()
    {
        $lesson = $this->buildLesson();
        $this->associateMany($lesson, ['user', 'category']);
        $lesson->words()->attach($this->randomizeWords());
        $this->user->pushActivity('started', $lesson);
        $this->calculateLessonDuration($lesson);

        return [$this->category, $lesson];
    }

    /**
     * Check the number of unlearned words in category.
     *
     * @return bool
     */
    protected function hasEnoughWords()
    {
        $baseQuery = $this->getUnlearnedWords();

        return $baseQuery->count() >= config('lesson.min_words');
    }

    /**
     * Select random words from a category.
     *
     * @return array
     */
    protected function randomizeWords()
    {
        $baseQuery = $this->getUnlearnedWords();

        return $baseQuery->pluck('id')->shuffle()->take(config('lesson.max_words'))->toArray();
    }

    /**
     * A helper method to associate a lesson with its parents.
     *
     * @param $lesson
     * @param array $parents
     * @return bool
     */
    protected function associateMany($lesson, array $parents)
    {
        foreach ($parents as $parent) {
            $lesson->$parent()->associate($this->$parent);
        }

        return $lesson->save();
    }

    /**
     * Get unlearned words of user in a category.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function getUnlearnedWords()
    {
        return $this->lessonType === Word::COMBINED
            ? $this->category->unlearnedWordsOf(auth()->user())
            : $this->category->unlearnedWordsOf(auth()->user())->ofLevel($this->lessonType);
    }

    /**
     * Calculate the lesson duration based on the number
     * of words in that lesson.
     *
     * @param $lesson
     * @return bool|int
     */
    protected function calculateLessonDuration($lesson)
    {
        $duration = counting($lesson->words) * config('lesson.time_per_word');

        return $lesson->update(['duration' => $duration]);
    }
}
