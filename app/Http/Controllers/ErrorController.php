<?php

namespace App\Http\Controllers;

use Inertia\Inertia;


class ErrorController extends Controller
{
    public function index()
    {
        return Inertia::render('404')->with('title', 'Nie znaleziono strony');
    }
}
