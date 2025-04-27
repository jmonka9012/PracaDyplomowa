<?php

use App\Http\Controllers\MyAccountController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

  // Strona moje konto
  Route::get('/moje-konto', [MyAccountController::class, 'index'])
    ->name('my-account');

  //zmiany danych
  Route::post('/moje-konto', [MyAccountController::class, 'store'])
    ->name('my-account.change');
});



