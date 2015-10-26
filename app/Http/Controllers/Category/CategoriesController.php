<?php

namespace FELS\Http\Controllers\Category;

use Illuminate\Contracts\Auth\Guard;
use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\WordRepository;
use FELS\Core\Repository\Contracts\LessonRepository;
use FELS\Core\Repository\Contracts\CategoryRepository;

class CategoriesController extends Controller
{
    protected $words;
    protected $lessons;
    protected $categories;
    protected static $user;

    public function __construct(WordRepository $words,
                                LessonRepository $lessons,
                                CategoryRepository $categories)
    {
        $this->words = $words;
        $this->lessons = $lessons;
        $this->categories = $categories;
        self::$user = app(Guard::class)->user();
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
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $category = $this->categories->findBySlug($slug);
        $lessons = $this->lessons->fetchLessons(self::$user, $category);
        $words = $this->words->fetchLearnedWords(self::$user, $category);

        return view('categories.show', compact('category', 'words', 'lessons'));
    }
}
