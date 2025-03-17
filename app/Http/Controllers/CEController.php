<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Inertia\Inertia;


class CEController extends Controller
{
    public function index(Request $request)
    {
        $routeName = $request->route()->getName();
        if ($routeName === 'jacek') {
            return Inertia::render('Jacek');
        } else if ($routeName === 'ce') {
            return Inertia::render('CE');
        }
    }
}
