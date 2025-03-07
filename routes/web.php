<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// Rejestracja
Route::get('/register', [RegisterUserController::class, 'create'])->name('register');
Route::post('/register', [RegisterUserController::class, 'store']);

// Strona domowa
Route::get('/', [HomeController::class, 'index'])->name('home');

// Strona bloga
Route::get('/blog', [BlogController::class, 'index'])->name('blog');

// Strona kontaktu
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

