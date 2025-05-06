<?php

use App\Http\Controllers\Events\EventController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Events\RequestEventController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\LiveVerificationController;
use App\Http\Controllers\Events\TicketSaleController;

Route::prefix('wydarzenia')->group(function() {

      // Strona zorganizuj wydarzenie
      Route::get('/zorganizuj-wydarzenie', [RequestEventController::class, 'index'])
            ->name('event-create')
            ->Middleware('organizerAccess');

      Route::post('/zorganizuj-wydarzenie', [RequestEventController::class, 'store'])
            ->name('event-create.post')
            ->Middleware('organizerAccess');

      Route::post('/zorganizuj-wydarzenie/zdjecia', [ImageUploadController::class, 'storeImages'])
            ->name('event-create.image')
            ->Middleware('organizerAccess');

      Route::get('/zorganizuj-wydarzenie/data', [RequestEventController::class, 'showData'])
            ->name('event-create.data')
            ->middleware('adminAccess');

            
      Route::post("/zoragnizuj-wydarzenie/walidacja-daty", [LiveVerificationController::class,'eventTimeTaken'])
            ->name('event-create.hall-check')
            ->middleware('organizerAccess');
      
      //Przeglądanie eventów
      Route::get('/data', [EventController::class, 'eventBrowserData'])
            ->name('event.browser.data')
            ->middleware('adminAccess');
      
      Route::get('/', [EventController::class, 'eventBrowser'])
            ->name('event.browser');

      Route::post('/kupuj', [TicketSaleController::class, 'store'])
            ->name('event-ticket.buy');
            
      // Dane eventu
      Route::get('/data/{event:slug}', [EventController::class, 'showData'])
            ->name('event.data')
            ->middleware('adminAccess');

});

Route::get('/{event}', [EventController::class, 'show'])
      ->where('event', 'wydarzenia/wydarzenie/[0-9]{4}-[0-9]{2}-[0-9]{2}/[0-9]+/([A-Za-z0-9]+(-[A-Za-z0-9]+)*)')
      ->name('event.show');