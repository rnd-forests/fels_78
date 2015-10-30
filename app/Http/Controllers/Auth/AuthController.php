<?php

namespace FELS\Http\Controllers\Auth;

use FELS\Events\UserHasRegistered;
use Illuminate\Contracts\Auth\Guard;
use FELS\Http\Requests\SignInRequest;
use FELS\Http\Controllers\Controller;
use FELS\Http\Requests\RegistrationRequest;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use FELS\Core\Repository\Contracts\UserRepository;

class AuthController extends Controller
{
    use ThrottlesLogins;

    protected $users, $auth;

    public function __construct(Guard $auth, UserRepository $users)
    {
        $this->auth = $auth;
        $this->users = $users;
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function getRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request to the application.
     *
     * @param RegistrationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(RegistrationRequest $request)
    {
        $credentials = $request->only(['name', 'email', 'password']);
        $user = $this->users->create($credentials);
        if (!$user) {
            return redirect()->route('auth.register');
        }
        event(new UserHasRegistered($user));
        flash()->info(trans('auth.account_activation'));

        return redirect()->home();
    }

    /**
     * Show the application login form.
     *
     * @return \Illuminate\View\View
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param SignInRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(SignInRequest $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = array_merge(
            $request->only(['email', 'password']), ['confirmed' => 1]
        );
        if ($this->auth->attempt($credentials, $request->has('remember'))) {
            session()->flash('app_status', 'login_success');
            $this->clearLoginAttempts($request);

            if ($this->auth->user()->isAdmin()) {
                return redirect()->route('admin.users');
            }

            return redirect()->intended('/');
        }
        session()->flash('login_error', trans('auth.login_error'));
        $this->incrementLoginAttempts($request);

        return redirect()->route('auth.login')
            ->withInput($request->only('email', 'remember'));
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        $this->auth->logout();
        session()->flash('app_status', 'logged_out');

        return redirect()->home();
    }

    /**
     * Activate user account.
     *
     * @param $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getActivate($code)
    {
        $user = $this->users->findByActivationCode($code);
        if ($this->canBeActivated($user)) {
            $this->auth->login($user);
            flash()->success(trans('auth.activation_success'));

            return redirect()->home();
        }
        flash()->warning(trans('auth.activation_error'));

        return redirect()->home();
    }

    /**
     * Check if user account can be activated or not.
     *
     * @param $user
     * @return bool
     */
    protected function canBeActivated($user)
    {
        return $user->update([
            'confirmation_code' => '',
            'confirmed' => true,
        ]);
    }

    /**
     * Get the user attribute used as login username.
     *
     * @return string
     */
    protected function loginUsername()
    {
        return 'email';
    }

    /**
     * Get the login path.
     *
     * @return string
     */
    protected function loginPath()
    {
        return '/auth/login';
    }
}
