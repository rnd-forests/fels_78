<?php

namespace FELS\Http\Controllers\Auth;

use Illuminate\Http\Request;
use FELS\Events\UserHasRegistered;
use FELS\Http\Controllers\Controller;
use FELS\Core\Repository\Contracts\UserRepository;

class RegistrationsController extends Controller
{
    protected $users;

    protected static $rules = [
        'name' => 'required|alpha_spaces|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|confirmed|min:6',
    ];

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
        $this->middleware('guest');
    }

    /**
     * Show the application sign up form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request to the application.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, self::$rules);
        $user = $this->users->create($request->only(['name', 'email', 'password']));
        event(new UserHasRegistered($user));
        flash()->info(trans('auth.activation.sent'));

        return redirect()->home();
    }

    /**
     * Activate user account.
     *
     * @param $code
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($code)
    {
        return $this->handleAccountActivation($this->users->findPendingActivationAccount($code));
    }

    /**
     * Handle the process of activating user account.
     *
     * @param $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function handleAccountActivation($user)
    {
        if ($this->users->clearActivationCode($user)) {
            auth()->login($user);
            flash()->success(trans('auth.activation.success'));

            return redirect()->home();
        }
        flash()->warning(trans('auth.activation.failure'));

        return redirect()->home();
    }
}
