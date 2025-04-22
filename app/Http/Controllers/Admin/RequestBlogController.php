<?php

namespace App\Http\Controllers\Admin;

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
        return Inertia::render('Admin/AddPost');
    }

    public function store(RequestBlogRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('post_image')) {
            $blogPostName = Str::slug($request->input('post_name'));
            $folder = 'blog_images/' . now()->format('Y/m') . '/' . $blogPostName;
        
            $imagePath = $request->file('post_image')->store($folder, 'public');
        } else {
            $imagePath = null;
        }

        $author = auth()->user()->author;

        if ($author) {
            $authorID = $author->id;
        } else {$authorID=1;}

        $request->merge(['thumbnail_path' => $imagePath]);

        BlogPost::create([
            'author_id'=>$authorID,
            'blog_post_name'=> $validatedData['post_name'],
            'blog_post_content'=> $validatedData['post_content'],    
            'thumbnail_path'=> $imagePath,
        ]);
        return redirect()->route('home');
    }
}
