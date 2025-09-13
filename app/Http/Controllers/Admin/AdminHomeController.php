<?php

namespace App\Http\Controllers\Admin;

use App\Models\Events\Genre;
use App\Models\FeaturedGenre;
use Inertia\Inertia;
use App\Http\Controllers\Controller;

class AdminHomeController extends Controller
{
    public function index()
    {
        $genres = Genre::orderBy('id', 'asc')->get();

        $featuredCategories = FeaturedGenre::all();

        return Inertia::render('Admin/AdminHome', [
            'genres' => $genres,
            'featured_categories' => $featuredCategories
        ])->with('title', 'Panel Administratora');;
    }
}
