<?php

namespace FELS\Http\Controllers\User;

use FELS\Http\Controllers\Controller;
use FELS\Core\Excel\Export\WordExporter;
use FELS\Core\Repository\Contracts\CategoryRepository;

class WordsController extends Controller
{
    protected $categories;

    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
        $this->middleware('auth');
    }

    /**
     * Filter words of categories.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        list($category, $type) = $this->parseRequest();
        $words = $this->categories->filterWords(auth()->user(), $category, $type);

        return view('users.words.index', compact('category', 'type', 'words'));
    }

    /**
     * Export learned words of a user to PDF.
     *
     * @param WordExporter $exporter
     */
    public function export(WordExporter $exporter)
    {
        $exporter->exportPdf(auth()->user()->words);
    }

    /**
     * Display learned words of a user.
     *
     * @return \Illuminate\View\View
     */
    public function learned()
    {
        $words = auth()->user()->words()->paginate(15);

        return view('users.words.learned', compact('words'));
    }

    /**
     * Parse filtering request from user.
     *
     * @return array
     */
    protected function parseRequest()
    {
        $request = app('request');
        $category = $request->has('in-category')
            ? $this->categories->findById($request->get('in-category'))
            : $this->categories->first();
        $type = $request->has('filter-by')
            ? $request->get('filter-by')
            : 'learned';

        return [$category, $type];
    }
}
