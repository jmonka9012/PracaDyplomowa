<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Strona domowa
Route::get('/', [HomeController::class, 'index'])
      ->name('home');

Route::get('/data', [HomeController::class, 'showData'])
      ->name('home.data');

// Strona kontaktu
Route::get('/kontakt', [ContactController::class, 'index'])
      ->name('contact');

// Strona hal
Route::get('/o-nas', [AboutUsController::class, 'index'])
      ->name('about-us');
