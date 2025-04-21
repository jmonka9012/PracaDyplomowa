<?php

namespace App\Http\Controllers;
            
use Inertia\Inertia;
use App\Models\Events\Genre;
use App\Models\Events\Event;
use App\Http\Resources\EventBrowserResource;

class HomeController extends Controller
{
    public function index()
    {
        $genres = Genre::orderBy('id', 'asc')->get();
        $upcomingEvents = Event::where('event_date', '>', now())
            ->where('pending', false)
            ->orderBy('event_date', 'asc')
            ->take(3)
            ->get();

        return Inertia::render('Home', [
            'genres' => $genres,
            'events' => EventBrowserResource::collection($upcomingEvents)->resolve()
        ]);
        
        

    }

    
}
