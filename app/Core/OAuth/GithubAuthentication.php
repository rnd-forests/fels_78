<?php

namespace FELS\Core\OAuth;

use FELS\Core\OAuth\Contracts\Extractable;
use FELS\Core\OAuth\Contracts\OAuthenticatable;

class GithubAuthentication extends AbstractOAuth implements
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
        return 'github';
    }

    /**
     * Get the authentication exception message.
     *
     * @return string
     */
    public function getAuthException()
    {
        return trans('auth.github_error');
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
            'github_name' => str_replace('https://github.com/', '', $data->user['html_url']),
        ]);
    }
}
