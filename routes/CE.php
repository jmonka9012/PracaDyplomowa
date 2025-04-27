<?php

use App\Http\Controllers\CEController;
use Illuminate\Support\Facades\Route;

// Strona Testowa dla matiego
Route::get('/ce', [CEController::class, 'index'])
      ->name('ce');

Route::get('/jacek', [CEController::class, 'index'])
      ->name('jacek');
