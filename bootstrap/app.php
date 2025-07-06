<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsDipendente;
use App\Http\Middleware\MustChangePassword;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middleware globali (per tutte le richieste)
        // $middleware->use(SomeGlobalMiddleware::class);

        // Middleware di route (per gruppi o singole rotte)
        $middleware->alias([
            'must_change_password' => MustChangePassword::class,
            // altri alias...
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
