<?php

namespace FELS\Http\Controllers\Pages;

use FELS\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * The homepage.
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        return view('pages.home');
    }
}
