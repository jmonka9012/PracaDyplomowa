<?php

use App\Http\Controllers\Events\EventController;
use Illuminate\Support\Facades\Route;

// Strona event
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('event.show');

// dane samego eventu, tymczasowe
Route::get('/events/data/{event:slug}', [EventController::class, 'showData'])->name('event.data');