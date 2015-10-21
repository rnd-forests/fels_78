<?php

namespace FELS\Http\Controllers\Admin;

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
     * @param $categorySlug
     * @return \Illuminate\View\View
     */
    public function index($categorySlug)
    {
        $category = $this->categories->findBySlug($categorySlug);
        $words = $category->words()->oldest('content')->paginate(10);

        return view('admin.categories.words', compact('category', 'words'));
    }
}
