<?php

use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Blog\PostController;
use App\Http\Controllers\Blog\RequestBlogController;
use Illuminate\Support\Facades\Route;

// Strona bloga
Route::get('/blog', [BlogController::class, 'index'])->name('blog');

//Strona pojedynczego posta
Route::get('/post', [PostController::class, 'index'])->name('post');

//strone dodawania bloga
Route::get('/stworz-post', [RequestBlogController::class, 'index'])->name('blog-create');