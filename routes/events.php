<?php

use App\Http\Controllers\Events\EventController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Events\RequestEventController;
use App\Http\Controllers\ImageUploadController;

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
      
      //Przeglądanie eventów
      Route::get('/data', [EventController::class, 'eventBrowserData'])
            ->name('event.browser.data')
            ->middleware('adminAccess');
      
      Route::get('/', [EventController::class, 'eventBrowser'])
            ->name('event.browser');
            
 
      // Dane eventu
      Route::get('/data/{event:slug}', [EventController::class, 'showData'])
            ->name('event.data')
            ->middleware('adminAccess');

});

Route::get('/{event}', [EventController::class, 'show'])
      ->where('event', '.*')
      ->name('event.show');

