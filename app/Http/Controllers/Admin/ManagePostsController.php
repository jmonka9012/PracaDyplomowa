<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\BlogPostBrowserResource;
use App\Models\Blog\BlogPost;
use Inertia\Inertia;
use App\Http\Controllers\Controller;


class ManagePostsController extends Controller
{
    public function index()
    {   
        $blogPosts = BlogPost::all();

        return Inertia::render('Admin/ManagePosts', [
            'blog_posts' => BlogPostBrowserResource::collection($blogPosts)
        ]);
    }

    public function showData()
    {
        $blogPosts = BlogPost::all();

        return response()->json([
            'blog_posts' => BlogPostBrowserResource::collection($blogPosts)
        ]);
    }
}
