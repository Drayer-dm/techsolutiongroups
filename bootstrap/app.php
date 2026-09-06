<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'jwt.custom' => \App\Http\Middleware\JwtMiddleware::class,
        ]);

        // Elige el idioma de la respuesta (es / en) en cada peticion. Va en los
        // dos grupos: la web lo necesita para los formularios y la API para que
        // los 422 salgan traducidos.
        //
        // En web va AL FINAL (append) porque necesita que la sesion ya este
        // arrancada; en api va PRIMERO (prepend) porque ahi no hay sesion y
        // conviene fijar el idioma antes que cualquier otro middleware.
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);

        $middleware->api(prepend: [
            \App\Http\Middleware\SetLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

    
    })->create();


