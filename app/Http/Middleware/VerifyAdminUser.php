<?php

namespace FELS\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use FELS\Exceptions\InvalidUserException;

class VerifyAdminUser
{
    protected $auth;

    /**
     * Constructor.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
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

        if (!$this->auth->user()->isAdmin()) {
            throw new InvalidUserException;
        }

        return $next($request);
    }
}
