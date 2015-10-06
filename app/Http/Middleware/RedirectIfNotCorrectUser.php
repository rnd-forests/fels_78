<?php

namespace FELS\Http\Middleware;

use Closure;
use FELS\Exceptions\InvalidUserException;
use Illuminate\Contracts\Auth\Guard;
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
        if ($request->route('users')) {
            $user = $this->users->findBySlug($request->route('users'));
            if (($user->id != $this->auth->user()->id) && !$this->auth->user()->isAdmin()) {
                throw new InvalidUserException;
            }
        }
        return $next($request);
    }
}
