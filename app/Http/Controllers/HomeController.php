<?php

namespace App\Http\Controllers;
            
use Inertia\Inertia;
use App\Models\Events\Genre;

class HomeController extends Controller
{
    public function index()
    {
        $genres = Genre::orderBy('id', 'asc')->get();
        
        return Inertia::render('Home', [
            'genres' => $genres
        ]);

    }
}
