<?php

namespace FELS\Jobs\Lesson;

use FELS\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use FELS\Core\Repository\Contracts\WordRepository;
use FELS\Core\Repository\Contracts\LessonRepository;

class StoreLessonResults extends Job implements SelfHandling
{
    protected $user;
    protected $words;
    protected $lesson;

    public function __construct($user, $words, $lesson)
    {
        $this->user = $user;
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
        $this->updatePivots($choices, $lesson);
        $this->updateLearnedWords();

        return [$lesson->category, $lesson];
    }

    /**
     * Mark the lesson as completed.
     *
     * @return \FELS\Entities\Lesson
     */
    protected function markLessonAsFinished()
    {
        $lesson = app(LessonRepository::class)->findById($this->lesson);
        $lesson->update(['finished' => true]);
        $this->recordActivity($lesson);

        return $lesson;
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
     * Capture finished-lesson activity of the user.
     *
     * @param $lesson
     * @return mixed
     */
    protected function recordActivity($lesson)
    {
        return $this->user->pushActivity('finished', $lesson);
    }

    /**
     * Update the current number of learned words of the user.
     *
     * @return mixed
     */
    protected function updateLearnedWords()
    {
        return $this->user->update([
            'learned_words' => $this->user->words()->count()
        ]);
    }

    /**
     * Update pivot tables.
     *
     * @param $choices
     * @param $lesson
     */
    protected function updatePivots($choices, $lesson)
    {
        foreach ($choices as $word => $choice) {
            $valid = $this->validateChoice($word, $choice);
            $lesson->words()->updateExistingPivot($word, [
                'answer_id' => $choice,
                'valid' => $valid
            ]);
            if ($valid) {
                $this->user->words()->attach($word);
            }
        }
    }
}
