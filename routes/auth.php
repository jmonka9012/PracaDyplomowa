<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/register', function () {
    return Inertia::render('Register', [
    'message' => 'Rejestracja'
    ]);
});
