<?php

namespace FELS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\AnswerRepository;

class AnswersController extends Controller
{
    protected $answers;

    public function __construct(AnswerRepository $answers)
    {
        $this->answers = $answers;
        $this->middleware('admin');
    }

    /**
     * Update an answer.
     *
     * @param Request $request
     * @param $id
     * @return string
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, config('rules.answer'));
        $answer = $this->answers->findById($id);
        $answer->update(['solution' => $request->get('solution')]);

        return $answer->toJson();
    }

    /**
     * Delete an answer.
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $answer = $this->answers->findById($id);
        $answer->delete();
    }
}
