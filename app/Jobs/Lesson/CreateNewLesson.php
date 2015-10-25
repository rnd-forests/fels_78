<?php

namespace FELS\Jobs\Lesson;

use FELS\Jobs\Job;
use FELS\Entities\Lesson;
use Illuminate\Contracts\Bus\SelfHandling;
use FELS\Core\Repository\Contracts\CategoryRepository;

class CreateNewLesson extends Job implements SelfHandling
{
    const MINIMUM_NUMBER_OF_WORDS = 5;
    const MAXIMUM_NUMBER_OF_WORDS = 20;

    protected $category;

    public function __construct($categoryId)
    {
        $this->category = app(CategoryRepository::class)->findById($categoryId);
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle()
    {
        return $this->hasEnoughWords()
            ? $this->buildLessonRelations()
            : false;
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
            'finished' => false
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
        $lesson->user()->associate(auth()->user());
        $lesson->category()->associate($this->category);
        $lesson->save();
        $lesson->words()->attach($this->randomizeWords());
        $this->recordActivity($lesson);

        return [$this->category, $lesson];
    }

    /**
     * Check the number of unlearned words in category.
     *
     * @return bool
     */
    protected function hasEnoughWords()
    {
        return $this->category
            ->words()
            ->unlearned()
            ->count() >= static::MINIMUM_NUMBER_OF_WORDS;
    }

    /**
     * Select random words from a category.
     *
     * @return array
     */
    protected function randomizeWords()
    {
        return array_values(
            $this->category
                ->words()
                ->unlearned()
                ->lists('id')
                ->shuffle()
                ->take(static::MAXIMUM_NUMBER_OF_WORDS)
                ->all()
        );
    }

    /**
     * Capture 'start lesson' activity of the user.
     *
     * @param $lesson
     * @return void
     */
    protected function recordActivity($lesson)
    {
        return auth()->user()->pushActivity('started', $lesson);
    }
}
