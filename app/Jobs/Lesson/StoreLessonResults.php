<?php

namespace FELS\Jobs\Lesson;

use FELS\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use FELS\Core\Repository\Contracts\WordRepository;
use FELS\Core\Repository\Contracts\LessonRepository;

class StoreLessonResults extends Job implements SelfHandling
{
    protected $words;
    protected $lesson;

    public function __construct($words, $lesson)
    {
        $this->words = $words;
        $this->lesson = $lesson;
    }

    /**
     * Execute the job.
     *
     * @return array
     */
    public function handle()
    {
        $lesson = $this->markLessonAsFinished();
        $choices = $this->parseUserChoices();
        foreach ($choices as $word => $choice) {
            $lesson->words()->updateExistingPivot($word, [
                'answer_id' => $choice,
                'valid' => $this->validateChoice($word, $choice)
            ]);
            $this->updateUserWordPivot($word, $choice);
        }
        $this->updateLearnedWordsCounter();

        return [$lesson->category, $lesson];
    }

    /**
     * Parse results from request data.
     *
     * @return array
     */
    protected function parseUserChoices()
    {
        return collect($this->words)->map(function ($item) {
            return $item = intval($item['choice']);
        })->toArray();
    }

    /**
     * Mark the lesson as completed.
     *
     * @return mixed
     */
    protected function markLessonAsFinished()
    {
        $lesson = app(LessonRepository::class)->findById($this->lesson);
        $lesson->update(['finished' => true]);
        $this->recordActivity($lesson);

        return $lesson;
    }

    /**
     * Check the correctness of the choice.
     *
     * @param $word
     * @param $choice
     * @return bool
     */
    protected function validateChoice($word, $choice)
    {
        $validChoices = app(WordRepository::class)
            ->findById($word)
            ->answers()
            ->lists('correct', 'id')
            ->toArray();

        return $validChoices[$choice] === 1;
    }

    /**
     * Capture 'finish lesson' activity of the user.
     *
     * @param $lesson
     * @return mixed
     */
    protected function recordActivity($lesson)
    {
        return auth()->user()->pushActivity('finished', $lesson);
    }

    /**
     * Update the current number of learned words of the user.
     *
     * @return mixed
     */
    protected function updateLearnedWordsCounter()
    {
        return auth()->user()->update([
            'learned_words' => auth()->user()->words()->count()
        ]);
    }

    /**
     * Update user word pivot table in case the choice is correct.
     *
     * @param $word
     * @param $choice
     */
    protected function updateUserWordPivot($word, $choice)
    {
        if ($this->validateChoice($word, $choice)) {
            auth()->user()->words()->attach($word);
        }
    }
}
