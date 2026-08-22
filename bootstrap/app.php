<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

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
        // $middleware->append(\App\Http\Middleware\ForceHttps::class);

        $middleware->trustProxies(at: '*', headers: Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_HOST |
            Request::HEADER_X_FORWARDED_PORT |
            Request::HEADER_X_FORWARDED_PROTO
        );


    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
