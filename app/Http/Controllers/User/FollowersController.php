<?php

namespace FELS\Http\Controllers\User;

use FELS\Entities\User;
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
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function index(User $user)
    {
        $followers = $user->followers()->paginate(20);

        return view('users.follows.followers', compact('user', 'followers'));
    }
}
