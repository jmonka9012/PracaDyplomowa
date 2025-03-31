<?php

namespace App\Http\Controllers;
            
use Inertia\Inertia;


class UsersPanelController extends Controller
{
    public function index()
    {
        return Inertia::render('Users');
    }
}
