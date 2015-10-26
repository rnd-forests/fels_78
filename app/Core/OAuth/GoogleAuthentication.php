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
        return 'google';
    }

    /**
     * Get the authentication exception message.
     *
     * @return string
     */
    public function getAuthException()
    {
        return trans('auth.google_error');
    }

    /**
     * Extract and update user profile using data
     * returned from provider.
     *
     * @param $user
     * @param $data
     * @return mixed
     */
    public function extractAndUpdate($user, $data)
    {
        return $user->update([
            'google_name' => str_replace('https://plus.google.com/', '', $data->user['url']),
        ]);
    }
}
