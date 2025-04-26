<?php

namespace App\Http\Controllers\Events;

use App\Http\Resources\EventBrowserResource;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Events\Event;
use App\Models\Events\Genre;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    public function show($event)
    {
        $event = Event::where('event_url', $event)
            ->with(['seats', 'standingTickets'])
            ->first();

        if(!$event){
            return redirect()->route('error404');
        }
        
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

    public function eventBrowser(Request $request)
    {   
        if (!$request->has('page')) {
            return redirect()->route('event.browser', ['page' => 1] + $request->except('page'));
        }

        $query = Event::where('pending', false);

        if($request->has('event_name') && !empty($request->event_name)){
            $query->where('event_name', 'like', '%' . $request->event_name . '%');
        }

        if ($request->has('date') && !empty($request->date)) {
                $query->whereDate('event_date', 
                Carbon::parse($request->date)->format('Y-m-d'));
        } else {
            if ($request->has('date_from') && !empty($request->date_from)) {
                $dateFrom = Carbon::parse($request->date_from)->format('Y-m-d');
                $query->whereDate('event_date', '>=', $dateFrom);
            }
        
            if ($request->has('date_to') && !empty($request->date_to)) {
                $dateTo = Carbon::parse($request->date_to)->format('Y-m-d');
                $query->whereDate('event_date', '<=', $dateTo);
            }
        }

        if ($request->filled('genres')) {
            $genreIds = is_array($request->genres) 
                ? $request->genres 
                : explode(',', $request->genres);
            
            $query->whereHas('genres', function($q) use ($genreIds) {
                $q->whereIn('genres.id', $genreIds);
            });
        }
        
        $events = $query
            ->orderBy('event_date', 'asc')
            ->paginate(10);

        $genres = Genre::orderBy('id', 'asc')->get();

        return Inertia::render('Events/EventBrowser', [  
            'events' => EventBrowserResource::collection($events)->response()->getData(true),
            'genres' => $genres,
            'filters' => [
                'event_name' => $request->input('name'),
                'date_from' => $request->input('date_from'),
                'date_to' => $request->input('date_to'),
                'date' => $request->input('date')
            ]
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
