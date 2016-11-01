<?php

namespace App\Http\Middleware;

use Closure;

class Authenticate
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (auth()->guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('log-in');
            }
        }

        return $next($request);
    }
}
