<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog\BlogPost;
use Inertia\Inertia;
use App\Http\Requests\RequestBlogRequest;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;

class RequestBlogController extends Controller
{
    public function index()
    {
        return Inertia::render('BlogRequest');
    }

    public function store(RequestBlogRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('event_image')) {
            $blogPostName = Str::slug($request->input('blog_post_name'));
            $folder = 'blog_images/' . now()->format('Y/m') . '/' . $blogPostName;
        
            $imagePath = $request->file('event_image')->store($folder, 'public');
        } else {
            $imagePath = null;
        }

        $author = auth()->user()->author;

        if ($author) {
            $authorID = $author->id;
        }

        $request->merge(['thumbnail_path' => $imagePath]);

        $blogPost = BlogPost::create([
            'author_id'=>$authorID,
            'blog_post_name'=> $validatedData['blog_post_name'],
            'blog_post_content'=> $validatedData['blog_post_content'],    
            'thumbnail_path'=> $imagePath,
        ]);
        return redirect()->route('home');
    }


}
