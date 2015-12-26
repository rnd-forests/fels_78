<?php

namespace FELS\Jobs\Word;

use FELS\Jobs\Job;
use FELS\Entities\Word;
use FELS\Entities\Answer;
use FELS\Core\Repository\Contracts\CategoryRepository;

class CreateNewWord extends Job
{
    /**
     * Create a new word.
     *
     * @return mixed
     */
    public function handle()
    {
        return $this->saveAnswersFor($this->saveNewWord());
    }

    /**
     * Save the word into a category.
     *
     * @return Word
     */
    public function saveNewWord()
    {
        return app(CategoryRepository::class)
            ->findById(request()->get('category'))->words()->create([
                'content' => request()->input('word.content'),
                'level' => request()->input('word.level'),
            ]);
    }

    /**
     * Save answers belong to this word.
     *
     * @param Word $word
     * @return array
     */
    protected function saveAnswersFor(Word $word)
    {
        return $word->answers()->createMany(
            $this->parseAnswers()->map(function ($answer) {
                return (new Answer)->fill([
                    'solution' => $answer['solution'],
                    'correct' => $answer['correct'],
                ]);
            })->toArray()
        );
    }

    /**
     * Parse the list of answers returned from the request.
     * Store these answers in a collection.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function parseAnswers()
    {
        return collect(array_values(request()->input('word.answers')));
    }
}
