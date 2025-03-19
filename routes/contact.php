<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// Strona kontaktu
Route::get('/kontakt', [ContactController::class, 'index'])->name('contact');