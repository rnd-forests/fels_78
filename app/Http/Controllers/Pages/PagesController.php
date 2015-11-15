<?php

namespace FELS\Http\Controllers\Pages;

use FELS\Http\Controllers\Controller;

class PagesController extends Controller
{
    /**
     * About page.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('pages.statics.about');
    }

    /**
     * Helper page.
     *
     * @return \Illuminate\View\View
     */
    public function help()
    {
        return view('pages.statics.help');
    }
}
