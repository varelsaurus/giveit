<?php
// bootstrap/app.php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CekRole; // <-- Pastikan ini di-import jika Anda menggunakannya di luar closure

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // 1. DAFTARKAN ROUTE MIDDLEWARE ANDA DI SINI
        $middleware->alias([
            'role' => CekRole::class, // atau \App\Http\Middleware\CekRole::class
            'auth' => \App\Http\Middleware\Authenticate::class, // Alias bawaan jika perlu diulang
        ]);

        // Jika Anda memiliki middleware global atau group
        // $middleware->web(append: [ ... ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();