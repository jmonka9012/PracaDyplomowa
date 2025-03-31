<?php

use App\Http\Controllers\UsersPanelController;
use Illuminate\Support\Facades\Route;


Route::get('/panel-administracji-użytkownicy', [UsersPanelController::class, 'index'])->name('admin.users');