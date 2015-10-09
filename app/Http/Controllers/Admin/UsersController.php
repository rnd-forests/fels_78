<?php

namespace FELS\Http\Controllers\Admin;

use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\UserRepository;

class UsersController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Get the list of the current users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = $this->users->paginate(50);

        return view('admin.users.current', compact('users'));
    }

    /**
     * Soft delete a user.
     *
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($slug)
    {
        $this->users->softDelete($slug);
        flash()->success(trans('admin.user_deleted'));

        return back();
    }
}
