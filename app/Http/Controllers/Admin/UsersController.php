<?php

namespace FELS\Http\Controllers\Admin;

use FELS\Http\Controllers\Controller;
use FELS\Http\Requests\RegistrationRequest;
use FELS\Core\Repository\Contracts\UserRepository;

class UsersController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
        $this->middleware('admin');
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
     * Load form to create new account.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store new account.
     *
     * @param RegistrationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RegistrationRequest $request)
    {
        $credentials = $request->only(['name', 'email', 'password']);
        $this->users->adminCreate($credentials);
        flash()->success(trans('admin.user_added'));

        return redirect()->route('admin.users');
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
