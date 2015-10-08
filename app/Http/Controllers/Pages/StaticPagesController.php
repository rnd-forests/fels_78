<?php

namespace FELS\Http\Controllers\Pages;

use FELS\Http\Controllers\Controller;

class StaticPagesController extends Controller
{
    /**
     * About page.
     */
    public function about()
    {
        return view('pages.statics.about');
    }

    /**
     * Helper page.
     */
    public function help()
    {
        return view('pages.statics.help');
    }

    /**
     * Frequently asked questions page.
     */
    public function faq()
    {
        return view('pages.statics.faq');
    }
}
