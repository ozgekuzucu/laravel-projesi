<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/*
|--------------------------------------------------------------------------
| bootstrap/app.php
| Hafta 3: Middleware kaydı
| Laravel v11 ve sonrası: app\Http\Kernel.php yerine burada yapılır
|--------------------------------------------------------------------------
*/

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Hafta 3: Middleware kaydı - 'giris.kontrol' takma adıyla tanımlıyoruz
        $middleware->alias([
            'giris.kontrol' => \App\Http\Middleware\GirisKontrol::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
