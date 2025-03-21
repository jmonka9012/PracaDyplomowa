<?php

use App\Http\Controllers\Events\SendEventQuote;
use Illuminate\Support\Facades\Route;

// Strona zorganizuj wydarzenie
Route::get('/zorganizuj-wydarzenie', [SendEventQuote::class, 'index'])->name('event-quote');
