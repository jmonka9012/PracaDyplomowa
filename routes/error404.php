<?php

use App\Http\Controllers\ErrorController;
use Illuminate\Support\Facades\Route;

// Strona 404
Route::get('/404', [ErrorController::class, 'index'])->name('error404');