<?php

namespace App\Http\Controllers\Events;

use App\Http\Resources\EventBrowserResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Models\Events\Event;
use App\Http\Resources\EventResource;


class EventController extends Controller
{
    public function show(Event $event)
    {
        $event->load(['seats', 'standingTickets']);

        return Inertia::render('Events/EventSingle', [
            'event' => new EventResource($event)
        ]);
    }

    public function showData(Event $event)
    {
        $event->load(['hall.sections', 'seats', 'standingTickets']);

        return response()->json([
            'event' => $event->load(['seats', 'standingTickets'])->toArray()
        ]);
    }

    public function eventBrowser(Event $event)
    {
        $events = Event::where('pending', false)->get();

        return Inertia::render('Events/EventBrowser', [
            'events' => EventBrowserResource::collection($events)->resolve()
        ]);
    }

    public function eventBrowserData(Event $event)
    {
        $events = Event::where('pending', false)->get();

        return response()->json([
            'events' => EventBrowserResource::collection($events)
        ]);
    }
}
