<?php

use App\Http\Controllers\MyAccountController;
use Illuminate\Support\Facades\Route;

// Strona moje konto
Route::get('/moje-konto', [MyAccountController::class, 'index'])->name('my-account');