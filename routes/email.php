<?php

use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

Route::get('/test-email', function () {
    Mail::to('test@example.com')->send(new TestEmail());
    return 'Email sent!';
});