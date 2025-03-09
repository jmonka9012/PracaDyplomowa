<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Strona Testowa dla matiego
Route::get('/new', [HomeController::class, 'index'])->name('new');
