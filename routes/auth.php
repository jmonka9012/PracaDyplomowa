<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\Auth\LogoutController;

// Rejestracja
Route::get('/register', [RegisterUserController::class, 'create'])->name('register');
Route::post('/register', [RegisterUserController::class, 'store']);

//Logowanie
Route::get('/login', [LoginUserController::class,'create'])->name('login');
Route::post('/login', [LoginUserController::class, 'store']);

//Wylogowanie
Route::middleware(['auth'])->group(function () {
      Route::post('/logout', [LogoutController::class,'destroy'])->name('logout');
});