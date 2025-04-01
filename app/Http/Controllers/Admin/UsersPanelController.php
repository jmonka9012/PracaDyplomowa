<?php

namespace App\Http\Controllers\Admin;
            
use Inertia\Inertia;
use App\Http\Controllers\Controller;


class UsersPanelController extends Controller
{
    public function index()
    {
        return Inertia::render('Users');
    }
}
