<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Closure;

class Social
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array(strtolower($request->service), array_keys(config('social.services')))) {
            return redirect()->back();
        }

        return $next($request);
    }
}
