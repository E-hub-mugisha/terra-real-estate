<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'permission' => \App\Http\Middleware\RequirePermission::class,
            'role'       => \App\Http\Middleware\CheckRole::class,
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
            \App\Http\Middleware\TrackLastSeen::class,
        ]);
        // The payment gateway cannot send a CSRF token; the callback checks its own shared secret.
        $middleware->validateCsrfTokens(except: ['payment/callback']);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
