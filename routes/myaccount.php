<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

// Strona bloga
Route::get('/moje-konto', [BlogController::class, 'index'])->name('my-account');