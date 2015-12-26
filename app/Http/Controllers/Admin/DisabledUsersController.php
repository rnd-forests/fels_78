<?php

namespace FELS\Http\Controllers\Admin;

use FELS\Entities\User;
use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\UserRepository;

class DisabledUsersController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;

        $this->middleware('auth:admin');
    }

    /**
     * Get the list of disabled users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = $this->users->disabled(15);

        return view('admin.users.disabled', compact('users'));
    }

    /**
     * Restore a disabled user.
     *
     * @param $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(User $user)
    {
        $this->users->restore($user);
        flash()->success(trans('admin.user.restored'));

        return back();
    }

    /**
     * Permanently delete a user.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $this->users->forceDelete($user);
        flash()->success(trans('admin.user.destroyed'));

        return back();
    }
}
