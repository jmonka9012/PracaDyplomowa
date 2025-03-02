<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Home', [
        'message' => 'Witaj w aplikacji z Inertia!'
    ]);
});
