<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\LoginUserController;

// Rejestracja
Route::get('/register', [RegisterUserController::class, 'create'])->name('register');
Route::post('/register', [RegisterUserController::class, 'store']);

//Logowanie i wylogowanie
Route::get('/login', [LoginUserController::class,'create'])->name('login');
Route::post('/login', [LoginUserController::class, 'store']);
//Route::post('/logout', [LoginUserController::class, 'destroy'])->middleware('auth');