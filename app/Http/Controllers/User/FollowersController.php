<?php

namespace FELS\Http\Controllers\User;

use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\UserRepository;

class FollowersController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
        $this->middleware('auth');
    }

    /**
     * Get the list of users that are following current user.
     *
     * @param $userSlug
     * @return \Illuminate\View\View
     */
    public function index($userSlug)
    {
        $user = $this->users->findBySlug($userSlug);
        $followers = $user->followers()->paginate(20);

        return view('users.follows.followers', compact('user', 'followers'));
    }
}
