<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\BlogPostBrowserResource;
use App\Models\Blog\BlogPost;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagePostsController extends Controller
{
    public function blogBrowserAdminShow(Request $request)
    {   
        if (!$request->has('page')) {
            return redirect()->route('admin.posts', ['page' => 1] + $request->except('page'));
        }

        $blogPosts = $this->getBlogPosts($request);

        return Inertia::render('Admin/ManagePosts', [
            'blog_posts' => BlogPostBrowserResource::collection($blogPosts)->response()->getData(true)
        ]);
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

            return redirect()->route('admin.posts')->with([
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
        $blogPosts = BlogPost::with(['author.user'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);

        return $blogPosts;
    }
}
