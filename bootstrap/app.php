<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::prefix('backend')->namespace('App\Http\Controllers\Backend')->group(base_path('routes/backend.php'));
            Route::prefix('frontend')->namespace('App\Http\Controllers\Frontend')->group(base_path('routes/frontend.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->appendToGroup('backend',  App\Http\Middleware\BackendTokenMiddleware::class);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
 

    })->create();
