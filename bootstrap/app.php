<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\CheckRolePermission;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);

        $middleware->alias([
            'role' => CheckRolePermission::class,
        ]);

        $middleware->group('company_team', [
            'auth',
            'role:admin,moderator,redactor'
        ]);

        $middleware->group('organizers', [
            'auth',
            'role:admin,moderator,redactor,organizer'
        ]);

        $middleware->group('verified_users', [
            'auth',
            'role:admin,moderator,redactor,organizer,verified_user'
        ]);

        $middleware->group('unverified_users', [
            'auth',
            'role:admin,moderator,redactor,organizer,verified_user,unverified_user'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
