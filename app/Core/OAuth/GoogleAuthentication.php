<?php

namespace FELS\Core\OAuth;

use FELS\Core\OAuth\Contracts\Extractable;
use FELS\Core\OAuth\Contracts\OAuthenticatable;

class GoogleAuthentication extends AbstractOAuth implements
    Extractable,
    OAuthenticatable
{
    /**
     * Get the open authentication provider.
     *
     * @return string
     */
    public function getAuthProvider()
    {
        return parent::GOOGLE;
    }

    /**
     * Get the authentication exception message.
     *
     * @return string
     */
    public function getAuthException()
    {
        return trans('auth.oauth.google.error');
    }

    /**
     * Extract and update user profile using data
     * returned from provider.
     *
     * @param $user
     * @param $data
     * @return bool|int
     */
    public function extractAndUpdate($user, $data)
    {
        $name = clear_pattern(parent::GOOGLE_URL, $data->user['url']);

        return $user->update(['google' => $name]);
    }
}
