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
        // Append SetCartCount to every web request
        $middleware->web(append: [
            \App\Http\Middleware\SetCartCount::class,
        ]);

        // Named middleware aliases for use in routes
        $middleware->alias([
            'cart.not.empty' => \App\Http\Middleware\EnsureCartNotEmpty::class,
            'track.view'     => \App\Http\Middleware\TrackProductView::class,
            'admin'          => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);

        $middleware->redirectTo(
            guests: '/admin/login',
            users: '/admin'
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
