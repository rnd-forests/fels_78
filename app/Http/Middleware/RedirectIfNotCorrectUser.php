<?php

namespace FELS\Http\Middleware;

use Closure;
use FELS\Core\Repository\Contracts\UserRepository;

class RedirectIfNotCorrectUser
{
    protected $users;

    /**
     * Constructor.
     *
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->guest()) {
            return redirect()->guest('auth/login');
        }

        $user = $request->route('users');
        if (!$user || !$user->is(auth()->user())) {
            abort(403);
        }

        return $next($request);
    }
}
