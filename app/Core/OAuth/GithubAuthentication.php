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
        return parent::GITHUB;
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
     * @return bool|int
     */
    public function extractAndUpdate($user, $data)
    {
        $name = clear_pattern(parent::GITHUB_URL, $data->user['html_url']);
        
        return $user->update(['github_name' => $name]);
    }
}
