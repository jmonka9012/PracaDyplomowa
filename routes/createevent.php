<?php

use App\Http\Controllers\Events\RequestEventController;
use Illuminate\Support\Facades\Route;

// Strona zorganizuj wydarzenie
Route::get('/zorganizuj-wydarzenie', [RequestEventController::class, 'index'])->name('event-quote');
