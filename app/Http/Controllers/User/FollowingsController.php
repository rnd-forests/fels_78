<?php

namespace FELS\Http\Controllers\User;

use FELS\Entities\User;
use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\UserRepository;

class FollowingsController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;

        $this->middleware('auth');
    }

    /**
     * Get the list of users that current user is following.
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function index(User $user)
    {
        $followings = $user->following()->paginate(20);

        return view('users.follows.following', compact('user', 'followings'));
    }
}
