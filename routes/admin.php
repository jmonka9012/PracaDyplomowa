<?php

use App\Http\Controllers\Admin\ManageUsersController;
use App\Http\Controllers\Admin\ManagePostsController;
use App\Http\Controllers\Admin\AddPostController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\CustomerServiceController;
use App\Http\Controllers\Admin\PendingEventsController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/uzytkownicy', [ManageUsersController::class, 'index'])->name('admin.users');
Route::get('/admin/wydarzenia', [PendingEventsController::class, 'index'])->name('admin.events');
Route::get('/admin/dodaj-post', [AddPostController::class, 'index'])->name('admin.post');
Route::get('/admin/zarzadzaj-postami', [ManagePostsController::class, 'index'])->name('admin.posts');
Route::get('/admin', [AdminHomeController::class, 'index'])->name('admin');
Route::get('/admin/obsluga-klienta', [CustomerServiceController::class, 'index'])->name('admin.customer-service');
