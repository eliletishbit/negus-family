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
        // Enregistrement du middleware de rôles
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        // Exclusion de la route webhook de la protection csrf
        $middleware->validateCsrfTokens(except: [
            '/payment/webhook',
        ]);

        // CORRECT : Enregistrement du middleware pour forcer le HTTPS globalement
        $middleware->append(\App\Http\Middleware\ForceHttps::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
