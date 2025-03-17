<?php

namespace App\Http\Controllers;

use Inertia\Inertia;


class MyAccountController extends Controller
{
    public function index()
    {
        return Inertia::render('My-Account');
    }
}
