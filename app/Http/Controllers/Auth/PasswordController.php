<?php

namespace FELS\Http\Controllers\Auth;

use Illuminate\Http\Request;
use FELS\Http\Controllers\Controller;
use FELS\Http\Requests\ResetPasswordRequest;
use Illuminate\Contracts\Auth\PasswordBroker;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PasswordController extends Controller
{
    protected $broker;
    
    public function __construct(PasswordBroker $broker)
    {
        $this->broker = $broker;
        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function getEmail()
    {
        return view('auth.password');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $response = $this->broker
            ->sendResetLink($request->only('email'), function ($message) {
                $message->subject(trans('passwords.subject'));
            });

        if ($response == PasswordBroker::RESET_LINK_SENT) {
            flash()->success(trans('passwords.sent'));

            return redirect()->home();
        }

        return back()->withErrors(['email' => trans($response)]);
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param null $token
     * @return $this
     * @throws NotFoundHttpException
     */
    public function getReset($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        return view('auth.reset')->with('token', $token);
    }

    /**
     * Reset the given user's password.
     *
     * @param ResetPasswordRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postReset(ResetPasswordRequest $request)
    {
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = $this->broker->reset($credentials, function ($user, $password) {
            $user->password = $password;
            $user->save();
            auth()->login($user);
        });

        if ($response == PasswordBroker::PASSWORD_RESET) {
            flash()->success(trans('passwords.reset'));

            return redirect()->home();
        }

        return back()->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }
}
