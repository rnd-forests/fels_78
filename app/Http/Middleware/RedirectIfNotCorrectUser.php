<?php

namespace FELS\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use FELS\Exceptions\InvalidUserException;
use FELS\Core\Repository\Contracts\UserRepository;

class RedirectIfNotCorrectUser
{
    protected $auth;
    protected $users;

    /**
     * Constructor.
     *
     * @param Guard $auth
     * @param UserRepository $users
     */
    public function __construct(Guard $auth, UserRepository $users)
    {
        $this->auth = $auth;
        $this->users = $users;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     * @throws InvalidUserException
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            return redirect()->guest('auth/login');
        }

        $routeKey = $request->route('users');
        if ($routeKey) {
            $user = $this->users->findBySlug($routeKey);
            if (!$user || !$user->is($this->auth->user())) {
                throw new InvalidUserException(trans('exceptions.invalid_user'));
            }
        }

        return $next($request);
    }
}
