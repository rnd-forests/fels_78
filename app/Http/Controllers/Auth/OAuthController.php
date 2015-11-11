<?php

namespace FELS\Http\Controllers\Auth;

use FELS\Http\Controllers\Controller;
use FELS\Core\OAuth\GithubAuthentication;
use FELS\Core\OAuth\GoogleAuthentication;
use FELS\Core\OAuth\FacebookAuthentication;
use FELS\Core\OAuth\Contracts\OAuthenticatable;
use FELS\Core\OAuth\Contracts\OAuthUserListener;

class OAuthController extends Controller implements OAuthUserListener
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Authenticate user using GitHub provider.
     *
     * @param GithubAuthentication $github
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticateWithGithub(GithubAuthentication $github)
    {
        return $this->authenticateWith($github);
    }

    /**
     * Authenticate user using Facebook provider.
     *
     * @param FacebookAuthentication $facebook
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticateWithFacebook(FacebookAuthentication $facebook)
    {
        return $this->authenticateWith($facebook);
    }

    /**
     * Authenticate user using Google provider.
     *
     * @param GoogleAuthentication $google
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticateWithGoogle(GoogleAuthentication $google)
    {
        return $this->authenticateWith($google);
    }

    /**
     * Log the user in the application using the given
     * authentication provider.
     *
     * @param OAuthenticatable $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticateWith(OAuthenticatable $provider)
    {
        return $provider->authorize(app('request')->has('code'), $this);
    }

    /**
     * Response to open authentication on success event.
     *
     * @param $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userHasLoggedIn($user)
    {
        flash()->success(trans('auth.social_auth_success'));

        return redirect()->route('users.show', $user);
    }
}
