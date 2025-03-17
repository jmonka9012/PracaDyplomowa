<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Inertia\Inertia;


class BlogController extends Controller
{
    public function index()
    {
        return Inertia::render('Blog');
    }
}
