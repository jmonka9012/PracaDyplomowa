<?php

use App\Http\Controllers\Events\EventController;
use App\Http\Controllers\Admin\FeaturedGenresController;
use App\Http\Controllers\Admin\ManageUsersController;
use App\Http\Controllers\Admin\ManagePostsController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\CustomerServiceController;
use App\Http\Controllers\Admin\PendingEventsController;
use App\Http\Controllers\Admin\ManageOrganizerController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function() {
      Route::get('/', [AdminHomeController::class, 'index'])
            ->name('admin')
            ->middleware('employeesAccess');
      
      Route::post('/kategorie/aktualizacja', [FeaturedGenresController::class, 'update'])
            ->name('admin.featured.update')
            ->middleware('employeesAccess');

      Route::get('/uzytkownicy', [ManageUsersController::class, 'index'])
            ->name('admin.users')
            ->middleware('adminAccess');

      Route::get('/uzytkownicy/data', [ManageUsersController::class, 'showData'])
            ->name('admin.users.data')
            ->middleware('adminAccess');

      Route::delete('/uzytkownicy/usun', [ManageUsersController::class, 'deleteUser'])
            ->name('admin.users.delete')
            ->middleware('adminAccess');

      Route::put('/uzytkownicy/{id}/status', [ManageUsersController::class, 'changeStatus'])
            ->name('admin.users.change_role')
            ->middleware('adminAccess');

      Route::put('/uzytkownicy/organizatorzy/{id}/status', [ManageOrganizerController::class, 'changeStatus'])
            ->name('admin.users.organizers.change_status')
            ->middleware('adminAccess');
      
      Route::get('/wydarzenia', [PendingEventsController::class, 'index'])
            ->name('admin.events')
            ->middleware('redactorAccess');

      Route::get('/wydarzenia/data', [PendingEventsController::class, 'showData'])
            ->name('admin.events.data')
            ->middleware('redactorAccess');

      Route::put('/wydarzenia/{event}/status', [EventController::class, 'changeEventStatus'])
            ->name('admin.events.status')
            ->middleware('adminAccess');

      Route::get('/{event}', [EventController::class, 'showPending'])
            ->where('event', 'wydarzenia/wydarzenie/[0-9]{4}-[0-9]{2}-[0-9]{2}/[0-9]+/([A-Za-z0-9]+(-[A-Za-z0-9]+)*)')
            ->name('event.show.pending')
            ->middleware('employeesAccess');

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

      Route::put('/obsluga-klienta/{id}/anulowanie-biletu', [CustomerServiceController::class, 'cancelTicket'])
            ->name('admin.customer-service.cancel-ticket')
            ->middleware('adminAccess');

      Route::put('/obsluga-klienta/{order}/anulowanie-zamowienia', [CustomerServiceController::class, 'cancelOrder'])
            ->name('admin.customer-service.cancel-order')
            ->middleware('adminAccess');
});