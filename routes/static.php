<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\Events\RequestEventController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Strona domowa
Route::get('/', [HomeController::class, 'index'])->name('home');

// Strona kontaktu
Route::get('/kontakt', [ContactController::class, 'index'])->name('contact');

// Strona zorganizuj wydarzenie
Route::get('/zorganizuj-wydarzenie', [RequestEventController::class, 'index'])->name('event-create');
Route::post('/zorganizuj-wydarzenie', [RequestEventController::class, 'store'])->name('event-create.post');
Route::post('/zorganizuj-wydarzenie', [RequestEventController::class, 'storeEventImages'])->name('event-create.image');

// Strona hal
Route::get('/o-nas', [AboutUsController::class, 'index'])->name('about-us');
