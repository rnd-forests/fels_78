<?php

namespace FELS\Http\Controllers\Admin;

use FELS\Http\Controllers\Controller;
use FELS\Http\Requests\CategoryRequest;
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
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        $this->categories->create($request->only(['name', 'description']));
        flash()->success(trans('admin.category_created'));

        return back();
    }

    /**
     * Load form to edit category.
     *
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function edit($slug)
    {
        $category = $this->categories->findBySlug($slug);

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update a category.
     *
     * @param CategoryRequest $request
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request, $slug)
    {
        $this->categories->update($request->only(['name', 'description']), $slug);
        flash()->success(trans('admin.category_updated'));

        return redirect()->route('admin.categories');
    }

    /**
     * Delete a category.
     *
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($slug)
    {
        $this->categories->delete($slug);
        flash()->success(trans('admin.category_deleted'));

        return back();
    }
}
