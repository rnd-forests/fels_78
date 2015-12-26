<?php

namespace FELS\Http\Controllers\Admin;

use FELS\Entities\Answer;
use Illuminate\Http\Request;
use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\AnswerRepository;

class AnswersController extends Controller
{
    protected $answers;

    public function __construct(AnswerRepository $answers)
    {
        $this->answers = $answers;

        $this->middleware('auth:admin');
    }

    /**
     * Update an answer.
     *
     * @param Request $request
     * @param Answer $answer
     * @return string
     */
    public function update(Request $request, Answer $answer)
    {
        $this->validate($request, config('rules.answer'));
        $this->answers->update(['solution' => $request->get('solution')], $answer);

        return $answer->toJson();
    }

    /**
     * Delete an answer.
     *
     * @param Answer $answer
     * @return mixed
     */
    public function destroy(Answer $answer)
    {
        $this->answers->delete($answer);
    }
}
