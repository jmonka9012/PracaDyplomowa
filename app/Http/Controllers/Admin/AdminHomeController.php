<?php

namespace App\Http\Controllers\Admin;

use App\Models\Events\Genre;
use Inertia\Inertia;
use App\Http\Controllers\Controller;


class AdminHomeController extends Controller
{
    public function index()
    {
        $genres = Genre::orderBy('id', 'asc')->get();

        return Inertia::render('Admin/AdminHome', [
            'genres' => $genres
        ]);
    }
}
