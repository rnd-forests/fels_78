<?php

namespace FELS\Http\Controllers\Pages;

use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\UserRepository;

class HomeController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * The homepage.
     *
     * @return \Illuminate\View\View
     */
    public function home()
    {
        if (auth()->check()) {
            $activityList = $this->users->getActivityFeedFor(auth()->user());

            return view('pages.home', compact('activityList'));
        }

        return view('pages.home');
    }
}
