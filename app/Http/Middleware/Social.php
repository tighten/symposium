<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
