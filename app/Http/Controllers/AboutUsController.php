<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use Inertia\Inertia;

class AboutUsController extends Controller
{
    public function index()
    {
        $halls = Hall::with('sections')->get();
        return Inertia::render('About-us', [
            'halls' => $halls,
        ]);
    }
}
