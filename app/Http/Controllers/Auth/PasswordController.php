<?php

namespace FELS\Http\Controllers\Auth;

use FELS\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Reset the given user's password.
     * (Override the original method in the trait)
     * Prevent double-hashing the password because we've
     * already used mutator for password attribute.
     *
     * @param \FELS\Entities\User $user
     * @param string $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = $password;
        $user->save();
        auth()->login($user);
    }
}
