<?php

namespace FELS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use FELS\Http\Controllers\Controller;
use FELS\Core\Search\Contracts\Searchable;

class SearchController extends Controller
{
    protected $finder;

    public function __construct(Searchable $finder)
    {
        $this->finder = $finder;
        $this->middleware('admin');
    }

    /**
     * Perform search queries.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $source = $request->get('type');
        $pattern = $request->get('q');
        $results = $this->finder->adminSearch($source, $pattern);

        return view('admin.search.results', compact('source', 'pattern', 'results'));
    }
}
