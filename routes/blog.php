<?php

use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Blog\PostController;
use Illuminate\Support\Facades\Route;

// Strona bloga
Route::get('/blog', [BlogController::class, 'index'])->name('blog');

//Strona pojedynczego posta
Route::get('/post', [PostController::class, 'index'])->name('post');
