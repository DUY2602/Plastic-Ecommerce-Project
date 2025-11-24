<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // 👇 THÊM ĐOẠN NÀY VÀO - ĐĂNG KÝ MIDDLEWARE
        $middleware->alias([
            'auth.check' => \App\Http\Middleware\ProjectMiddleware::class,
            'admin' => \App\Http\Middleware\ProjectMiddleware::class . ':admin',
            'user' => \App\Http\Middleware\ProjectMiddleware::class . ':user',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
