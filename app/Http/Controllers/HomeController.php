<?php

namespace App\Http\Controllers;
            
use App\Models\FeaturedGenre;
use Inertia\Inertia;
use App\Models\Events\Genre;
use App\Models\Events\Event;
use App\Models\Blog\BlogPost;
use App\Http\Resources\EventBrowserResource;
use App\Http\Resources\BlogPostBrowserResource;

class HomeController extends Controller
{
    public function index()
    {
        $genres = Genre::orderBy('id', 'asc')->get();

        $upcomingEvents = Event::where('event_date', '>', now())
            ->where('pending', false)
            ->orderBy('event_date', 'asc')
            ->take(3)
            ->with(['standingTickets', 'standingTickets'])
            ->get();
        
        $newestBlogPosts = BlogPost::orderBy('created_at', 'desc')
            ->take(4)
            ->get();
        
        $featuredCategories = FeaturedGenre::all();

        return Inertia::render('Home', [
            'genres' => $genres,
            'events' => EventBrowserResource::collection($upcomingEvents)->resolve(),
            'blog_posts' => BlogPostBrowserResource::collection($newestBlogPosts)->resolve(),
            'featured_categories' => $featuredCategories
        ]);
    }

    public function showData()
    {
        $genres = Genre::orderBy('id', 'asc')->get();
        $upcomingEvents = Event::where('event_date', '>', now())
            ->where('pending', false)
            ->orderBy('event_date', 'asc')
            ->take(3)
            ->get();
        
        $newestBlogPosts = BlogPost::orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $featuredCategories = FeaturedGenre::all();

            return response()->json([
            'genres' => $genres,
            'events' => EventBrowserResource::collection($upcomingEvents)->resolve(),
            'blog_posts' => BlogPostBrowserResource::collection($newestBlogPosts)->resolve(),
            'featured_categories' => $featuredCategories
        ]);
    }
    
}
