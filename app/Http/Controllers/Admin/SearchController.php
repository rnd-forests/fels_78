<?php

namespace FELS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use FELS\Http\Controllers\Controller;
use FELS\Core\Search\Contracts\Searchable;

class SearchController extends Controller
{
    protected $search;

    public function __construct(Searchable $search)
    {
        $this->search = $search;

        $this->middleware('auth:admin');
    }

    /**
     * Perform search queries.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        list($source, $pattern) = [$request->get('type'), $request->get('q')];
        $results = $this->search->byAdministrator($source, $pattern);

        return view('admin.search.results', compact('source', 'pattern', 'results'));
    }
}
