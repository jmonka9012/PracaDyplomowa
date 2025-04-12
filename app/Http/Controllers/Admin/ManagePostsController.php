<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Http\Controllers\Controller;


class ManagePostsController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/ManagePosts');
    }
}
