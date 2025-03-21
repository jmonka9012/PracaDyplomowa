<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SendEventQuote extends Controller
{
    public function index()
    {
        return Inertia::render('RequestEvent');
    }
}
