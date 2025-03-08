<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

// Strona bloga
Route::get('/blog', [BlogController::class, 'index'])->name('blog');