<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);
        
        // Temporarily disable CSRF for login routes
        $middleware->validateCsrfTokens(except: [
            'login',
            'register',
            'simple-login-post'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
