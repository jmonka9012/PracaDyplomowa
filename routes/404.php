<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::fallback(function () {
      return Inertia::render('404')->withViewData(['title' => 'strona nie znaleziona']);
  })->name('404');