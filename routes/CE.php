<?php

use App\Http\Controllers\CEController;
use Illuminate\Support\Facades\Route;

// Strona Testowa dla matiego
Route::get('/ce', [CEController::class, 'index'])
      ->name('ce');

Route::get('/jacek', [CEController::class, 'index'])
      ->name('jacek');


Route::get('/jacek/test1', [CEController::class, 'getTest1'])
      ->name('jacek.test1');


Route::get('/jacek/test2', [CEController::class, 'getTest2'])
      ->name('jacek.test2');
