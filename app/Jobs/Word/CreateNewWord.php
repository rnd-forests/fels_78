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
        $answerCollection = collect(request()->input('word.answers'))->reverse()->values();

        return $word->answers()->createMany(
            $answerCollection->map(function ($data) {
                return (new Answer)->fill([
                    'solution' => $data['solution'],
                    'correct' => $data['correct'],
                ]);
            })->toArray()
        );
    }
}
