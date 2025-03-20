<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\Auth\LogoutController;

// Rejestracja
Route::get('/rejestracja', [RegisterUserController::class, 'create'])->name('register');
Route::post('/rejestracja', [RegisterUserController::class, 'store']);

//Logowanie
Route::get('/login', [LoginUserController::class,'create'])->name('login');
Route::post('/login', [LoginUserController::class, 'store'])->name('login-post');

//Wylogowanie
Route::middleware(['auth'])->group(function () {
      Route::post('/logout', [LogoutController::class,'destroy'])->name('logout');
});
