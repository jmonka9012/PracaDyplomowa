<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Static\PrivacyPolicyController;
use App\Http\Controllers\Static\TermsOfUseController;
use App\Http\Controllers\Static\FAQController;
use App\Http\Controllers\CustomerSupportRequest;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
      ->name('home');

Route::get('/data', [HomeController::class, 'showData'])
      ->name('home.data')
      ->middleware('adminAccess');

Route::get('/kontakt', [ContactController::class, 'index'])
      ->name('contact');

Route::get('/o-nas', [AboutUsController::class, 'index'])
      ->name('about-us');

Route::get('/regulamin', [TermsOfUseController::class, 'index'])
      ->name('terms-of-use');

Route::get('/polityka-prywatnosci', [PrivacyPolicyController::class, 'index'])
      ->name('privacy-policy');

Route::get('/faq', [FAQController::class, 'index'])
      ->name('faq');

Route::post('/pomoc', [CustomerSupportRequest::class, 'store'])
      ->name('support-ticket-send')
      ->middleware('throttle:3,10');