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

      Route::get('/kupuj/{order}/platnosc', [TicketSaleController::class, 'payment'])
            ->name('event-ticket.buy.payment');

      Route::post('/kupuj/form/post', [TicketSaleController::class, 'orderDataForm'])
            ->name('event-ticket.buy.form.post');

      Route::get('/kupuj/{order}/detale', [TicketSaleController::class, 'orderDetailsForm'])
            ->name('event-ticket.buy.form.details');

      Route::post('/kupuj/{order}/detale/update', [TicketSaleController::class, 'orderDetailsUpdate'])
            ->name('event-ticket.buy.form.details.post');

      Route::get('/kupuj/{order}/podsumowanie', [TicketSaleController::class, 'orderSummary'])
            ->name('event-ticket.buy.form.summary');
      
      Route::get('/tickets/payment/success', [TicketSaleController::class, 'paymentSuccess'])
            ->name('tickets.payment.success');
      
      Route::get('/tickets/payment/cancel', [TicketSaleController::class, 'paymentCancel'])
            ->name('tickets.payment.cancel');
            
      // Dane eventu
      Route::get('/data/{event:slug}', [EventController::class, 'showData'])
            ->name('event.data')
            ->middleware('adminAccess');
});

Route::get('/{event}', [EventController::class, 'show'])
      ->where('event', 'wydarzenia/wydarzenie/[0-9]{4}-[0-9]{2}-[0-9]{2}/[0-9]+/([A-Za-z0-9]+(-[A-Za-z0-9]+)*)')
      ->name('event.show');