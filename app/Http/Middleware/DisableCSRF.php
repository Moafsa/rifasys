<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DisableCSRF
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Temporarily disable CSRF for login routes
        if ($request->is('login') || $request->is('login/*')) {
            return $next($request);
        }
        
        return $next($request);
    }
}
