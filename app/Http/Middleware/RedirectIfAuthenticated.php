<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (auth()->guard($guard)->check()) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
