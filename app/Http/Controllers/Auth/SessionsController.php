<?php

namespace FELS\Http\Controllers\Auth;

use Illuminate\Http\Request;
use FELS\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class SessionsController extends Controller
{
    const LOGIN_NAME = 'email';
    const LOGIN_PATH = '/auth/login';

    use ThrottlesLogins;

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Show the application sign in form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle a sign in request to the application.
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, config('rules.session'));
        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }
        $credentials = $this->getCredentials($request);
        if (auth()->attempt($credentials, $request->has('remember'))) {
            return $this->handleSuccessAuthentication($request);
        }
        session()->flash('login_error', trans('auth.login.error'));
        $this->incrementLoginAttempts($request);

        return redirect()->route('auth.login')->withInput($request->only('email', 'remember'));
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        auth()->logout();
        flash()->success(trans('auth.logged.out'));

        return redirect()->home();
    }

    /**
     * Handle a success authentication process.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function handleSuccessAuthentication($request)
    {
        session()->flash('app_status', 'login_success');
        $this->clearLoginAttempts($request);

        return redirect()->intended('/');
    }

    /**
     * Get user credentials from request.
     *
     * @param Request $request
     * @return array
     */
    protected function getCredentials($request)
    {
        return array_merge($request->only(['email', 'password']), ['confirmed' => 1]);
    }

    /**
     * Get the user attribute used as login username.
     *
     * @return string
     */
    protected function loginUsername()
    {
        return self::LOGIN_NAME;
    }

    /**
     * Get the login path.
     *
     * @return string
     */
    protected function loginPath()
    {
        return self::LOGIN_PATH;
    }
}
