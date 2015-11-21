<?php

namespace FELS\Http\Controllers\Admin;

use FELS\Entities\Category;
use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\CategoryRepository;

class CategoryWordController extends Controller
{
    protected $categories;

    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;

        $this->middleware('admin');
    }

    /**
     * Display words of a category.
     *
     * @param Category $category
     * @return \Illuminate\View\View
     */
    public function index(Category $category)
    {
        $words = $this->categories->fetchWordsFor($category);

        return view('admin.categories.words', compact('category', 'words'));
    }
}
