<?php

namespace FELS\Http\Controllers\User;

use FELS\Entities\Word;
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
        list($category, $type, $level) = $this->parseRequest();
        $words = $this->categories->filterWords(auth()->user(), $category, $type, $level);

        return view('users.words.index', compact('category', 'type', 'words', 'level'));
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
        $category = $this->categories->findOrFirst(request()->get('in-category'));
        $type = request()->input('filter-by', Word::LEARNED);
        $level = request()->input('with-level', Word::COMBINED);

        return [$category, $type, $level];
    }
}
