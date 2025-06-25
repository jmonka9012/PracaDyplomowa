<?php

namespace App\Http\Controllers\Admin;

use App\Models\Events\Genre;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\FeaturedCategory;


class AdminHomeController extends Controller
{
    public function index()
    {
        $genres = Genre::orderBy('id', 'asc')->get();

        $featuredCategories = FeaturedCategory::all();

        return Inertia::render('Admin/AdminHome', [
            'genres' => $genres,
            'featured_categories' => $featuredCategories
        ]);
    }
}
