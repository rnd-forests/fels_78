<?php

namespace FELS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use FELS\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Loads login form for administrators.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.auth.login');
    }

    /**
     * Authenticates administrators.
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, config('rules.admin-session'));
        $credentials = $request->only(['email', 'password']);
        if (auth()->guard('admin')->attempt($credentials)) {
            session()->flash('app_status', 'login_success');

            return redirect()->route('admin.users.index');
        }
        session()->flash('login_error', trans('auth.login.error'));

        return redirect()->route('admin.login')->withInput($request->only('email'));
    }

    /**
     * Logs administrator out of application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        auth()->guard('admin')->logout();
        flash()->success(trans('auth.logged.out'));

        return redirect()->route('admin.login');
    }
}
