<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterUserController;
use Illuminate\Support\Facades\Route;

// Rejestracja
Route::get('/register', [RegisterUserController::class, 'create'])->name('register');
Route::post('/register', [RegisterUserController::class, 'store']);

// Strona domowa
Route::get('/', [HomeController::class, 'index'])->name('home');