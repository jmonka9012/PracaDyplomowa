<?php

use App\Http\Controllers\Events\RequestEventController;
use Illuminate\Support\Facades\Route;

// Strona zorganizuj wydarzenie
Route::get('/zorganizuj-wydarzenie', [RequestEventController::class, 'index'])->name('event-create');
Route::post('/zorganizuj-wydarzenie', [RequestEventController::class, 'store'])->name('event-create.post');