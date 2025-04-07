<?php

use App\Http\Controllers\LiveVerificationController;
use Illuminate\Support\Facades\Route;

Route::post("/walidacja/uzytkownik-istnieje", [LiveVerificationController::class,"userExists"])->name("verification.user");

Route::post("/walidacja/email", [LiveVerificationController::class,"isEmail"])->name("verification.email");
