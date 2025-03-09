<?php

namespace App\Http\Controllers;
            
use Inertia\Inertia;


class NewController extends Controller
{
    public function index()
    {
        return Inertia::render('New');
    }
}
