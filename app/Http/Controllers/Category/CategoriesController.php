<?php

namespace FELS\Http\Controllers\Category;

use FELS\Entities\Category;
use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\WordRepository;
use FELS\Core\Repository\Contracts\LessonRepository;
use FELS\Core\Repository\Contracts\CategoryRepository;

class CategoriesController extends Controller
{
    protected $words;
    protected $lessons;
    protected $categories;

    public function __construct(WordRepository $words,
                                LessonRepository $lessons,
                                CategoryRepository $categories)
    {
        $this->words = $words;
        $this->lessons = $lessons;
        $this->categories = $categories;

        $this->middleware('auth');
    }

    /**
     * Display all categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = $this->categories->paginate(15);

        return view('categories.index', compact('categories'));
    }

    /**
     * Display a single category.
     *
     * @param Category $category
     * @return \Illuminate\View\View
     */
    public function show(Category $category)
    {
        $lessons = $this->lessons->fetchLessons(auth()->user(), $category);
        $words = $this->words->fetchLearnedWords(auth()->user(), $category);

        return view('categories.show', compact('category', 'words', 'lessons'));
    }
}
