<?php

namespace FELS\Http\Controllers\Pages;

use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\UserRepository;

class MembersController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;

        $this->middleware('auth');
    }

    /**
     * Get the list of all current members.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $members = $this->users->paginate(32);

        return view('pages.members', compact('members'));
    }
}
