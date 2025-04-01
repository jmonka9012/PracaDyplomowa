<?php

namespace App\Http\Controllers;
use App\Models\Hall;
use Illuminate\Http\Request;
use Inertia\Inertia;


class CEController extends Controller
{
    public function index(Request $request)
    {
        $routeName = $request->route()->getName();
        if ($routeName === 'jacek') {
            $halls = Hall::with('sections')->get();
            return Inertia::render('Jacek', [
                'halls' => $halls,
            ]);
        } else if ($routeName === 'ce') {
            return Inertia::render('CE');
        }
    }
}
