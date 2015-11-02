<?php

namespace FELS\Http\Controllers\Category;

use Illuminate\Http\Request;
use FELS\Jobs\Lesson\CreateNewLesson;
use FELS\Http\Controllers\Controller;
use FELS\Jobs\Lesson\StoreLessonResults;
use FELS\Core\Repository\Contracts\LessonRepository;

class LessonsController extends Controller
{
    protected $lessons;

    public function __construct(LessonRepository $lessons)
    {
        $this->lessons = $lessons;
        $this->middleware('auth');
    }

    /**
     * Store new lesson.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $flag = $this->dispatchFrom(CreateNewLesson::class, $request, [
            'user' => auth()->user()
        ]);
        if (!$flag) {
            flash()->warning(trans('lesson.not_enough_words'));
            
            return back();
        }
        flash()->success(trans('lesson.created'));

        return redirect()->route('categories.lessons.show', $flag);
    }

    /**
     * Display a lesson.
     *
     * @param $categorySlug
     * @param $lessonId
     * @return \Illuminate\View\View
     */
    public function show($categorySlug, $lessonId)
    {
        $lesson = $this->lessons->findLesson($categorySlug, $lessonId);

        return view('categories.lessons.show', compact('lesson'));
    }

    /**
     * Store results of the lesson.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $flag = $this->dispatchFrom(StoreLessonResults::class, $request, [
            'user' => auth()->user()
        ]);

        return redirect()->route('categories.lessons.results', $flag);
    }

    /**
     * Display the result of a lesson.
     *
     * @param $categorySlug
     * @param $lessonId
     * @return \Illuminate\View\View
     */
    public function results($categorySlug, $lessonId)
    {
        $lesson = $this->lessons->findLesson($categorySlug, $lessonId);

        return view('categories.lessons.results', compact('lesson'));
    }
}
