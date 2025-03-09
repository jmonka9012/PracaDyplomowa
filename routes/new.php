<?php

use App\Http\Controllers\NewController;
use Illuminate\Support\Facades\Route;

// Strona Testowa dla matiego
Route::get('/new', [NewController::class, 'index'])->name('new');
