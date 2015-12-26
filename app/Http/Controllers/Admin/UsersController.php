<?php

namespace FELS\Http\Controllers\Admin;

use FELS\Entities\User;
use Illuminate\Http\Request;
use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\UserRepository;

class UsersController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;

        $this->middleware('auth:admin');
    }

    /**
     * Get the list of the current users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = $this->users->paginate(15);

        return view('admin.users.current', compact('users'));
    }

    /**
     * Load form to create new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store new user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, config('rules.registration'));
        $credentials = $request->only(['name', 'email', 'password']);
        $this->users->adminCreate($credentials);
        flash()->success(trans('admin.user.added'));

        return redirect()->route('admin.users.index');
    }

    /**
     * Soft delete a user.
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $this->users->softDelete($user);
        flash()->success(trans('admin.user.deleted'));

        return back();
    }
}
