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
            ->with(['standingTickets', 'standingTickets', 'genres'])
            ->get();
        
        $newestBlogPosts = BlogPost::orderBy('created_at', 'desc')
            ->take(4)
            ->get();
        
        $featuredCategories = FeaturedGenre::with('genre:id,genre_name')->get()
            ->map(function ($item) {
                return array_merge(
                    $item->toArray(),
                    ['genre_name' => $item->genre->genre_name]
                );
            })
            ->map(function ($item) {
                unset($item['genre']);
                return $item;
            });

        return Inertia::render('Home', [
            'genres' => $genres,
            'events' => EventBrowserResource::collection($upcomingEvents)->resolve(),
            'blog_posts' => BlogPostBrowserResource::collection($newestBlogPosts)->resolve(),
            'featured_categories' => $featuredCategories
        ])->with('title', 'Event Machen');
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

        $featuredCategories = FeaturedGenre::with('genre:id,genre_name')->get()
            ->map(function ($item) {
                return array_merge(
                    $item->toArray(),
                    ['genre_name' => $item->genre->genre_name]
                );
            })
            ->map(function ($item) {
                unset($item['genre']);
                return $item;
            });

            return response()->json([
            'genres' => $genres,
            'events' => EventBrowserResource::collection($upcomingEvents)->resolve(),
            'blog_posts' => BlogPostBrowserResource::collection($newestBlogPosts)->resolve(),
            'featured_categories' => $featuredCategories
        ]);
    }
    
}
