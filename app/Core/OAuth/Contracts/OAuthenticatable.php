<?php

namespace FELS\Core\OAuth\Contracts;

interface OAuthenticatable
{
    /**
     * Get the OAuth provider name.
     *
     * @return string
     */
    public function getAuthProvider();

    /**
     * Authorize user with given authentication provider.
     *
     * @param $code
     * @param $listener
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authorize($code, $listener);

    /**
     * Get the authentication exception message.
     *
     * @return string
     */
    public function getAuthException();
}
