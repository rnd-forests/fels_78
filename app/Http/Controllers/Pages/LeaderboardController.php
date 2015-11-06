<?php

namespace FELS\Http\Controllers\Pages;

use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\UserRepository;

class LeaderboardController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
        $this->middleware('auth');
    }

    /**
     * Display the memorized words leaderboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = $this->users->getLeaderboard();

        return view('pages.leaderboard', compact('users'));
    }
}
