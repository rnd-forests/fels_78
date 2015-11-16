<?php

namespace FELS\Jobs\Word;

use FELS\Jobs\Job;
use FELS\Entities\Word;
use FELS\Entities\Answer;
use Illuminate\Contracts\Bus\SelfHandling;
use FELS\Core\Repository\Contracts\CategoryRepository;

class CreateNewWord extends Job implements SelfHandling
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
                'content' => $this->parseWordContent(),
                'level' => $this->parseWordLevel(),
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
        return collect(array_values(head(request()->only('word.answers'))['answers']));
    }

    /**
     * Parse word content returned from the request.
     *
     * @return string
     */
    protected function parseWordContent()
    {
        return head(request()->only('word.content'))['content'];
    }

    /**
     * Parse word difficulty level from the request.
     *
     * @return string
     */
    protected function parseWordLevel()
    {
        return head(request()->only('word.level'))['level'];
    }
}
