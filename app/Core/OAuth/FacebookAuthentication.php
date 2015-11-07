<?php

namespace FELS\Core\OAuth;

use FELS\Core\OAuth\Contracts\OAuthenticatable;

class FacebookAuthentication extends AbstractOAuth implements OAuthenticatable
{
    /**
     * Get the open authentication provider.
     *
     * @return string
     */
    public function getAuthProvider()
    {
        return parent::FACEBOOK;
    }

    /**
     * Get the authentication exception message.
     *
     * @return string
     */
    public function getAuthException()
    {
        return trans('auth.facebook_error');
    }
}
