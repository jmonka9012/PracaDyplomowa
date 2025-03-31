<?php

use App\Http\Controllers\Admin\UsersPanelController;
use Illuminate\Support\Facades\Route;

Route::get('/panel-administracji-uzytkownicy', [UsersPanelController::class, 'index'])->name('admin.users');