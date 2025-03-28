<?php

use App\Http\Controllers\MyAccountController;
use Illuminate\Support\Facades\Route;

// Strona moje konto
Route::middleware('auth')->group(function () {
      Route::get('/moje-konto', [MyAccountController::class, 'index'])->name('my-account');
  });

//zmiany danych
Route::middleware('auth')->group(function () {
  Route::post('/moje-konto', [MyAccountController::class, 'store'])->name('my-account.change');
});

