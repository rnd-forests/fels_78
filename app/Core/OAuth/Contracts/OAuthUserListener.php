<?php

namespace FELS\Core\OAuth\Contracts;

interface OAuthUserListener
{
    /**
     * Response to open authentication on success event.
     *
     * @param $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userHasLoggedIn($user);
}
