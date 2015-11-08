<?php

namespace FELS\Http\Middleware;

use Closure;

class VerifyAdminUser
{
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

        if (! auth()->user()->isAdmin()) {
            abort(403);
        }

        return $next($request);
    }
}
