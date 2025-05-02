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
        $blogPosts = BlogPost::with(['author.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return Inertia::render('Admin/ManagePosts', [
            'blog_posts' => BlogPostBrowserResource::collection($blogPosts)->response()->getData(true)
        ]);
    }

    public function showData()
    {
        $blogPosts = BlogPost::with(['author.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'blog_posts' => BlogPostBrowserResource::collection($blogPosts)->response()->getData(true),
        ]);
    }
}
