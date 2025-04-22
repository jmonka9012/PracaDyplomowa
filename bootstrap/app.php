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

        $middleware->group('employeesAccess', [
            'auth',
            'role:admin,moderator,redactor,blog_author'
        ]);

        $middleware->group('adminAccess', [
            'auth',
            'role:admin,moderator'
        ]);

        $middleware->group('redactorAccess', [
            'auth',
            'role:admin,moderator,redactor'
        ]);

        $middleware->group('blogAccess', [
            'auth',
            'role:admin,moderator,redactor,blog_author'
        ]);

        $middleware->group('organizerAccess', [
            'auth',
            'role:admin,moderator,redactor,blog_author,organizer'
        ]);

        $middleware->group('loggedInAccess', [
            'auth',
            'role:admin,moderator,redactor,blog_author,organizer,verified_user,unverified_user'
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
