<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return redirect()->route('login')
                ->with('error', 'Você precisa fazer login primeiro.');
        }

        if (!$request->user()->hasVerifiedEmail()) {
            return redirect()->route('verification.method')
                ->with('error', 'Você precisa verificar sua conta antes de continuar.');
        }

        return $next($request);
    }
}

