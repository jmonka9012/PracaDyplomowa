<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\BlogPostBrowserResource;
use App\Models\Blog\BlogPost;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Enums\BlogPostType;

class ManagePostsController extends Controller
{
    public function blogBrowserAdminShow(Request $request)
    {   
        if (!$request->has('page')) {
            return redirect()->route('admin.posts', ['page' => 1] + $request->except('page'));
        }

        $blogPosts = $this->getBlogPosts($request);
        $blogPostTypes = BlogPostType::values();

        return Inertia::render('Admin/ManagePosts', [
            'blogPostTypes' => $blogPostTypes,
            'blog_posts' => BlogPostBrowserResource::collection($blogPosts)->response()->getData(true)
        ])->with('title', 'Zarządzaj Postami');
    }

    public function blogBrowserAdminShowData(Request $request)
    {
        if (!$request->has('page')) {
            return redirect()->route('admin.posts.data', ['page' => 1] + $request->except('page'));
        }
        $blogPosts = $this->getBlogPosts($request);

        return response()->json([
            'blog_posts' => BlogPostBrowserResource::collection($blogPosts)->response()->getData(true),
        ]);
    }

    public function deletePost(Request $request)
    {
        $validatedData = $request->validate([
            'blog_id' => 'required|integer|exists:blog_posts,id'
        ]);

        try{
            DB::beginTransaction();
            

            $post = BlogPost::findOrFail($validatedData['blog_id']);
            $post->delete(); 

            DB::commit();

            $blogPosts = $this->getBlogPosts($request);

            return redirect()->back()->with([
                'blog_posts' => BlogPostBrowserResource::collection($blogPosts)->response()->getData(true)
            ]);            
            
        } catch (\Exception $e){
            DB::rollBack();

            return response()->json([
                'blog_deleted' => false,
                'message' => 'Post nie został usunięty',
            ]);
        }
    }

    protected function getBlogPosts(Request $request)
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

        if($request->has('blog_post_name') && !empty($request->blog_post_name)){
            $query->where('blog_post_name', 'like', '%' . $request->blog_post_name . '%');
        }

        $blogPosts = BlogPost::with(['author.user'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
        $blogPosts = $query
            ->paginate(20)
            ->appends($request->query());
        return $blogPosts;
    }
}
