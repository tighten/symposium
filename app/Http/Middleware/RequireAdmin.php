<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RequireAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (! optional($request->user())->isAdmin()) {
            throw new NotFoundHttpException();
        }

        return $next($request);
    }
}
