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
    ->withMiddleware(function (Middleware $middleware) {
        // Behind a TLS-terminating proxy (Railway, Render, Fly, ...): trust the
        // X-Forwarded-* headers so generated URLs use https, not http.
        $middleware->trustProxies(at: '*');

        $middleware->web(append: [
            App\Http\Middleware\LocalizationMiddleware::class,
        ]);

        $middleware->alias([
            'admin' => App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withProviders([
        Illuminate\Filesystem\FilesystemServiceProvider::class,
    ])
    ->create();
