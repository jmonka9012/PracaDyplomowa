<?php

namespace App\Http\Controllers\Events;

use App\Http\Resources\EventBrowserResource;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Events\Event;
use App\Models\Events\Genre;
use App\Http\Resources\EventResource;


class EventController extends Controller
{
    public function show($event)
    {
        $event = Event::where('event_url', $event)
            ->with(['seats', 'standingTickets'])
            ->firstOrFail();
        
        $closestEvents = $event->getRelatedEvents();

        return Inertia::render('Events/EventSingle', [
            'event' => new EventResource($event),
            'related_events' => EventBrowserResource::collection($closestEvents)
        ]);
    }

    public function showData(Event $event)
    {
        $event->load(['hall.sections', 'seats', 'standingTickets']);

        $closestEvents = $event->getRelatedEvents();

        return response()->json([
            'event' => $event->load(['seats', 'standingTickets'])->toArray(),
            'related_events' => EventBrowserResource::collection($closestEvents)
        ]);
    }

    public function eventBrowser(Event $event)
    {
        $events = Event::where('pending', false)
            ->orderBy('event_date', 'asc')
            ->paginate(10);

        $genres = Genre::orderBy('id', 'asc')->get();

        return Inertia::render('Events/EventBrowser', [
            //'events' => EventBrowserResource::collection($events)->resolve(), stara werjsa, można potem usunąć  
            'events' => EventBrowserResource::collection($events)->response()->getData(true),
            'genres' => $genres,
        ]);
    }

    public function eventBrowserData(Event $event)
    {
        $events = Event::where('pending', false)
            ->orderBy('event_date', 'asc')
            ->paginate(10);
        $genres = Genre::orderBy('id', 'asc')->get();

        return response()->json([
            'events' => EventBrowserResource::collection($events)->response()->getData(true),
            'genres' => $genres
        ]);
    }
}
