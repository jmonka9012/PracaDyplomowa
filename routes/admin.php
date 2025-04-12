<?php

use App\Http\Controllers\Admin\ManageUsersController;
use App\Http\Controllers\Admin\ManagePostsController;
use App\Http\Controllers\Admin\RequestBlogController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\CustomerServiceController;
use App\Http\Controllers\Admin\PendingEventsController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('company_team')->group(function() {
      Route::get('/uzytkownicy', [ManageUsersController::class, 'index'])
            ->name('admin.users');

      Route::get('/uzytkownicy/data', [ManageUsersController::class, 'showData'])
            ->name('admin.users.data');

      Route::get('/wydarzenia', [PendingEventsController::class, 'index'])
            ->name('admin.events');

      Route::get('/wydarzenia/data', [PendingEventsController::class, 'showData'])
            ->name('admin.events.data');

      Route::get('/dodaj-post', [RequestBlogController::class, 'index'])
            ->name('admin.add-post');

      Route::get('/zarzadzaj-postami', [ManagePostsController::class, 'index'])
            ->name('admin.posts');

      Route::get('/', [AdminHomeController::class, 'index'])
            ->name('admin');

      Route::get('/obsluga-klienta', [CustomerServiceController::class, 'index'])
            ->name('admin.customer-service');
});
