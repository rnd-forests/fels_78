<?php

namespace FELS\Http\Controllers\Category;

use JavaScript;
use FELS\Entities\Category;
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
        $flag = $this->dispatch(new CreateNewLesson(
            $this->getAuthUser(),
            $request->input('categoryId'),
            $request->input('lessonType')
        ));

        if (!$flag) {
            flash()->warning(trans('lesson.not.enough.words'));

            return back();
        }
        flash()->success(trans('lesson.created'));

        return redirect()->route('categories.lessons.show', $flag);
    }

    /**
     * Display a lesson (can be processing lesson
     * or completed lesson).
     *
     * @param Category $category
     * @param $lessonId
     * @return \Illuminate\View\View
     */
    public function show(Category $category, $lessonId)
    {
        $lesson = $this->lessons->findLesson($category, $lessonId);
        JavaScript::put(['lessonDuration' => $lesson->duration]);
        $this->authorize('showLesson', $lesson);

        return view('categories.lessons.show', compact('lesson'));
    }

    /**
     * Store and process results of the lesson.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $flag = $this->dispatch(new StoreLessonResults(
            $this->getAuthUser(),
            $request->input('words'),
            $request->input('lesson')
        ));

        return redirect()->route('categories.lessons.show', $flag);
    }
}
