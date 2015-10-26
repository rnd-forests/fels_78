<?php

namespace FELS\Jobs\Word;

use FELS\Jobs\Job;
use FELS\Entities\Word;
use FELS\Entities\Answer;
use Illuminate\Http\Request;
use Illuminate\Contracts\Bus\SelfHandling;
use FELS\Core\Repository\Contracts\CategoryRepository;

class CreateNewWord extends Job implements SelfHandling
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return mixed
     */
    public function handle()
    {
        $word = $this->saveNewWord();

        return $this->saveAnswersFor($word);
    }

    /**
     * Save the word into a category.
     *
     * @return Word
     */
    public function saveNewWord()
    {
        $category = app(CategoryRepository::class)
            ->findById($this->request->get('category'));
        return $category->words()->create([
            'content' => $this->parseWordContent()
        ]);
    }

    /**
     * Save answers belong to this word.
     *
     * @param Word $word
     * @return mixed
     */
    protected function saveAnswersFor(Word $word)
    {
        return $word->answers()->createMany(
            $this->parseAnswersFromRequest()->map(function ($answer) {
                return new Answer([
                    'solution' => $answer['solution'],
                    'correct' => $answer['correct']
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
    protected function parseAnswersFromRequest()
    {
        return collect(array_values(head(
            $this->request->only('word.answers'))['answers']
        ));
    }

    /**
     * Parse word content returned from the request.
     *
     * @return string
     */
    protected function parseWordContent()
    {
        return head($this->request->only('word.content'))['content'];
    }
}
