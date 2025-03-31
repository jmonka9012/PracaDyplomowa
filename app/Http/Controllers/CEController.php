<?php

namespace App\Http\Controllers;
use App\Models\Hall;
use Illuminate\Http\Request;
use Inertia\Inertia;


class CEController extends Controller
{
    public function index(Request $request)
    {

        $halls = Hall::with('sections')->get();

        return Inertia::render('Jacek', [
            'halls' => $halls,
        ]);

        $routeName = $request->route()->getName();
        if ($routeName === 'jacek') {
            return Inertia::render('Jacek');
        } else if ($routeName === 'ce') {
            return Inertia::render('CE');
        }
    }
}
