<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogPostBrowserResource;
use App\Http\Resources\BlogResource;
use App\Http\Resources\AuthorResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Blog\BlogPost;
use App\Enums\BlogPostType;


class BlogController extends Controller
{
    public function show($blog)
    {
        $blog = BlogPost::with(['author.user'])
            ->where('blog_post_url', $blog)
            ->firstOrFail();

        if(!$blog){
            return redirect()->route('error404');
        }

        $relatedPosts = $blog->getRelatedPosts();

        return Inertia::render('Blog/BlogSingle', [
            'blog_post' => new BlogResource($blog),
            'related_posts' => BlogPostBrowserResource::collection($relatedPosts),
        ]);
    }

    public function showData(BlogPost $blog)
    {
        $blog->load(['author.user']);
        $relatedPosts = $blog->getRelatedPosts();

        return response()->json([
            'blog_post' => new BlogResource($blog),
            'related_posts' => BlogPostBrowserResource::collection($relatedPosts),
        ]);
    }

    public function blogBrowserData(BlogPost $blog)
    {
        $blog = BlogPost::orderBy('created_at', 'desc')
            ->paginate(10);

        $blogPostTypes = BlogPostType::values();


        return response()->json([
            'blog_post' => BlogPostBrowserResource::collection($blog)->response()->getData(true),
            'blogPostTypes' => $blogPostTypes
        ]);
    }

    public function blogBrowser(Request $request)
    {
        if (!$request->has('page')) {
            return redirect()->route('blog', ['page' => 1] + $request->except('page'));
        }

        $query = BlogPost::orderBy('created_at', 'desc');

        if ($request->filled('blog_post_type')) {
            $requestType = strtolower($request->blog_post_type);
            $validTypes = array_map('strtolower', BlogPostType::values());

            if (in_array($requestType, $validTypes)) {
                $query->whereRaw('LOWER(blog_post_type) = ?', [$requestType]);
            }
        }

        $blog_posts = $query
            ->paginate(12)
            ->appends($request->query());

        $blogPostTypes = BlogPostType::values();

        return Inertia::render('Blog/Blog', [
            'blog_posts' => BlogPostBrowserResource::collection($blog_posts)->response()->getData(true),
            'filter' => $request->input('blog_post_type'),
            'blogPostTypes' => $blogPostTypes
        ]);
    }
}
