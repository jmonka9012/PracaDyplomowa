<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\LoginUserController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordConfirmationController;

// Rejestracja
Route::get('/rejestracja', [RegisterUserController::class, 'create'])->name('register');
Route::post('/rejestracja', [RegisterUserController::class, 'store'])->name('register.post');

//Logowanie
Route::get('/login', [LoginUserController::class,'create'])->name('login');
Route::post('/login', [LoginUserController::class, 'store'])->name('login.post');

//Wylogowanie
Route::middleware(['auth'])->group(function () {
      Route::post('/logout', [LogoutController::class,'destroy'])->name('logout');
});


// Emaile do weryfikacji
Route::get('/email/verify', [EmailVerificationController::class, 'show'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}', [EmailVerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

Route::post('/email/resend', [EmailVerificationController::class, 'resend'])
    ->middleware(['auth', 'throttle:5,10'])
    ->name('verification.resend');

// Potwierdzenie hasła
Route::post('/confirm-password', [PasswordConfirmationController::class, 'confirmPassword'])
    ->middleware(['auth'])->name('password.confirm'); 