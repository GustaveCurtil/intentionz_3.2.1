<?php

use Illuminate\Http\Request;
use App\Http\Middleware\DetectDevice;
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
        $middleware->alias([
            'detectDevice' => DetectDevice::class,
        ]);
        $middleware->redirectGuestsTo(fn (Request $request) => route('aanmelden')); /* OM NIET DEFAULT NAAR DE LOGIN ROUTE TE LEIDEN*/
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
