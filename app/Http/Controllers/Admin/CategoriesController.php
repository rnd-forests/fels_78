<?php

namespace FELS\Http\Controllers\Admin;

use FELS\Entities\Category;
use Illuminate\Http\Request;
use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\CategoryRepository;

class CategoriesController extends Controller
{
    protected $categories;

    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
        
        $this->middleware('admin');
    }

    /**
     * Get the paginated list of all categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = $this->categories->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Create new category.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, config('rules.category'));
        $this->categories->create($request->only(['name', 'description']));
        flash()->success(trans('admin.category.created'));

        return back();
    }

    /**
     * Load form to edit category.
     *
     * @param Category $category
     * @return \Illuminate\View\View
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update a category.
     *
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, config('rules.category'));
        $this->categories->update($request->only(['name', 'description']), $category);
        flash()->success(trans('admin.category.updated'));

        return redirect()->route('admin.categories.index');
    }

    /**
     * Delete a category.
     *
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $this->categories->delete($category);
        flash()->success(trans('admin.category.deleted'));

        return back();
    }
}
