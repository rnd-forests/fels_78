<?php

namespace FELS\Http\Controllers\Admin;

use FELS\Entities\Word;
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
     * Display individual word.
     *
     * @param Word $word
     * @return \Illuminate\View\View
     */
    public function show(Word $word)
    {
        return view('admin.words.show', compact('word'));
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
     * Store new word.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $this->dispatch(new CreateNewWord);
        flash()->success(trans('admin.word.created'));

        return redirect()->route('admin.words.index');
    }

    /**
     * Update the content of a word.
     *
     * @param Request $request
     * @param Word $word
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Word $word)
    {
        $this->validate($request, config('rules.word'));
        $this->words->update([
            'content' => $request->get('content'),
            'level' => $request->get('level'),
        ], $word);

        return $word->toJson();
    }

    /**
     * Delete a word.
     *
     * @param Word $word
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Word $word)
    {
        $this->words->delete($word);

        if (!request()->ajax()) {
            flash()->success(trans('admin.word.deleted'));

            return redirect()->route('admin.words.index');
        }
    }
}
