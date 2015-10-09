<?php

namespace FELS\Http\Controllers\Admin;

use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\UserRepository;

class DisabledUsersController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
        $this->middleware('admin');
    }

    /**
     * Get the list of disabled users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = $this->users->disabled(50);

        return view('admin.users.disabled', compact('users'));
    }

    /**
     * Restore a disabled account.
     *
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($slug)
    {
        $this->users->restore($slug);
        flash()->success(trans('admin.user_restored'));

        return back();
    }

    /**
     * Permanently delete a user.
     *
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($slug)
    {
        $this->users->forceDelete($slug);
        flash()->success(trans('admin.user_destroyed'));

        return back();
    }
}
