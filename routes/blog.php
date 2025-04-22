<?php

use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Blog\PostController;
use App\Http\Controllers\Admin\RequestBlogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageUploadController;

Route::prefix('blog')->group(function() {

      // Strona bloga
      Route::get('/', [BlogController::class, 'index'])->name('blog');

      //Strona pojedynczego posta
      Route::get('/post', [PostController::class, 'index'])->name('post');

      Route::get('/dodaj-post', [RequestBlogController::class, 'index'])
      ->name('blog-create')
      ->middleware('blogAccess');

      Route::post('/dodaj-post/dodaj', [RequestBlogController::class, 'store'])
      ->name('blog-create.post')
      ->middleware('blogAccess');

      Route::post('/dodaj-post/zdjecia', [ImageUploadController::class, 'storeImages'])
      ->name('blog-create.image')
      ->Middleware('blogAccess');

});