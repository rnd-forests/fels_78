<?php

namespace FELS\Core\OAuth;

use FELS\Exceptions\InvalidUserException;
use FELS\Core\Repository\Contracts\UserRepository;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Laravel\Socialite\Contracts\User as SocialiteUser;

abstract class AbstractOAuth
{
    const GOOGLE = 'google';
    const GITHUB = 'github';
    const FACEBOOK = 'facebook';
    const GITHUB_URL = 'https://github.com/';
    const GOOGLE_URL = 'https://plus.google.com/';

    protected $users;
    protected $socialite;

    public function __construct(UserRepository $users, Socialite $socialite)
    {
        $this->users = $users;
        $this->socialite = $socialite;
    }

    /**
     * Authorize user with given authentication provider.
     *
     * @param $code
     * @param $listener
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authorize($code, $listener)
    {
        if (!$code) {
            return $this->getAuthorizationUrl();
        }
        $data = $this->handleProviderCallback();
        $user = $this->handleUserCreation($data);
        auth()->login($user, true);

        return $listener->userHasLoggedIn($user);
    }

    /**
     * Get the provider authorization URL.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function getAuthorizationUrl()
    {
        return $this->socialite->driver($this->getAuthProvider())->redirect();
    }

    /**
     * Handle provider callback. Get the user instance
     * for authenticated user.
     *
     * @return SocialiteUser
     */
    protected function handleProviderCallback()
    {
        return $this->socialite->driver($this->getAuthProvider())->user();
    }

    /**
     * Create new user.
     *
     * @param $data
     * @return \Illuminate\Database\Eloquent\Model
     * @throws InvalidUserException
     */
    protected function handleUserCreation($data)
    {
        $user = $this->users->oauthCreate($this->parseProviderData($data), $this->getAuthProvider());
        if (!$user) {
            throw new InvalidUserException($this->getAuthException());
        }
        if (method_exists(static::class, 'extractAndUpdate')) {
            $this->extractAndUpdate($user, $data);
        }

        return $user;
    }

    /**
     * Get common returned data from provider.
     *
     * @param SocialiteUser $data
     * @return array
     */
    protected function parseProviderData(SocialiteUser $data)
    {
        return [
            'name' => $data->getName(),
            'email' => $data->getEmail(),
            'auth_provider_id' => $data->getId(),
        ];
    }
}
