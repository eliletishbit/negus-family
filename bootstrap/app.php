<?php

use App\Http\Middleware\\ForceHttps;
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
        //on renseigne le middleware qui gere les roles
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        //exclusion de la route webhook de la protection csrf
        $middleware->validateCsrfTokens(except: [
            '/payment/webhook', // Utilise le chemin exact défini dans tes routes
        ]);

        //middleware pour forcer le https en production
        $middleware->web(append: [
            ForceHttps::class,
        ]);


    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
