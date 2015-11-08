<?php

namespace FELS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use FELS\Jobs\Word\CreateNewWord;
use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\WordRepository;

class WordsController extends Controller
{
    protected $words;

    public function __construct(WordRepository $words)
    {
        $this->words = $words;
        $this->middleware('admin');
    }

    /**
     * Display all words.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $words = $this->words->paginate(15);

        return view('admin.words.index', compact('words'));
    }

    /**
     * Load form to create a new word.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.words.create');
    }

    /**
     * Display individual word.
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $word = $this->words->findById($id);

        return view('admin.words.show', compact('word'));
    }

    /**
     * Store new word.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->dispatch(new CreateNewWord);
        flash()->success(trans('admin.word_created'));

        return redirect()->route('admin.words.index');
    }

    /**
     * Update the content of a word.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['content' => 'required']);
        $word = $this->words->findById($id);
        $word->update(['content' => $request->get('content')]);

        return $word->toJson();
    }

    /**
     * Delete a word.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $word = $this->words->findById($id);
        $word->delete();

        if (! $request->ajax()) {
            flash()->success(trans('admin.word_deleted'));

            return redirect()->route('admin.words.index');
        }
    }
}
