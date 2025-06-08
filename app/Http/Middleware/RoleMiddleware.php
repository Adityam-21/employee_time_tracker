<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Make comparison case-insensitive
        if (strcasecmp(auth()->user()->role, $role) !== 0) {
            abort(403);
        }


        return $next($request);
    }
}
