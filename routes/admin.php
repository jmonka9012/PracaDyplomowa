<?php

use App\Http\Controllers\Admin\ManageUsersController;
use App\Http\Controllers\Admin\ManagePostsController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\CustomerServiceController;
use App\Http\Controllers\Admin\PendingEventsController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function() {
      Route::get('/', [AdminHomeController::class, 'index'])
            ->name('admin')
            ->middleware('employeesAccess');

      Route::get('/uzytkownicy', [ManageUsersController::class, 'index'])
            ->name('admin.users')
            ->middleware('adminAccess');

      Route::get('/uzytkownicy/data', [ManageUsersController::class, 'showData'])
            ->name('admin.users.data')
            ->middleware('adminAccess');

      Route::get('/wydarzenia', [PendingEventsController::class, 'index'])
            ->name('admin.events')
            ->middleware('redactorAccess');

      Route::get('/wydarzenia/data', [PendingEventsController::class, 'showData'])
            ->name('admin.events.data')
            ->middleware('redactorAccess');

      Route::get('/zarzadzaj-postami', [ManagePostsController::class, 'blogBrowserAdminShow'])
            ->name('admin.posts')
            ->middleware('blogAccess');

      Route::get('/zarzadzaj-postami/data', [ManagePostsController::class, 'blogBrowserAdminShowData'])
            ->name('admin.posts.data')
            ->middleware('blogAccess');

      Route::delete('/zaradzaj-postami/usun', [ManagePostsController::class, 'deletePost'])
            ->name('admin.posts.delete')
            ->middleware('adminAccess');


      Route::get('/obsluga-klienta', [CustomerServiceController::class, 'show'])
            ->name('admin.customer-service')
            ->middleware('redactorAccess');

      Route::get('/obsluga-klienta/data', [CustomerServiceController::class, 'showData'])
            ->name('admin.customer-service.data')
            ->middleware('redactorAccess');
      
      Route::put('/obsluga-klienta/{id}/status', [CustomerServiceController::class, 'changeStatus'])
            ->name('admin.customer-service.change_status')
            ->middleware('redactorAccess');
});
