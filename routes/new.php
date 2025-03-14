<?php

use App\Http\Controllers\NewController;
use Illuminate\Support\Facades\Route;

// Strona Testowa dla matiego
Route::get('/ce', [NewController::class, 'index'])->name('ce');
