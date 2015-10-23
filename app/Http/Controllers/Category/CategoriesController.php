<?php

namespace FELS\Http\Controllers\Category;

use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\CategoryRepository;

class CategoriesController extends Controller
{
    protected $categories;

    public function __construct(CategoryRepository $categories)
    {
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
     * Display a specific category.
     *
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $category = $this->categories->findBySlug($slug);
        $words = $category->words()->paginate(15);

        return view('categories.show', compact('category', 'words'));
    }
}
