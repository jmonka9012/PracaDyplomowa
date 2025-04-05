<?php

use App\Http\Controllers\LiveVerificationController;
use Illuminate\Support\Facades\Route;

Route::post("/walidacja", [LiveVerificationController::class,"userExists"])->name("verification.user");

Route::post("/walidacja2", [LiveVerificationController::class,"isEmail"])->name("verification.email");
