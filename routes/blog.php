<?php

use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Blog\PostController;
use App\Http\Controllers\Admin\RequestBlogController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageUploadController;

Route::prefix('blog')->group(function() {

      // Strona bloga
      Route::get('/data', [BlogController::class, 'blogBrowserData'])
            ->name('blog.data')
            ->middleware('adminAccess');
      
      
      Route::get('/', [BlogController::class, 'blogBrowser'])
            ->name('blog');

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

      Route::get('/data/{blog:slug}', [BlogController::class, 'showData'])
            ->where('blog_post', '.*')
            ->name('blog.show')
            ->Middleware('adminAccess');
});

Route::get('/{blog}', [BlogController::class, 'show'])
      ->where('blog', 'blog/[0-9]{4}-[0-9]{2}-[0-9]{2}/([A-Za-z]+(-[A-Za-z]+)+)')
      ->name('blog.show');
