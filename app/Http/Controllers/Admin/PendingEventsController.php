<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Events\Event;
use App\Http\Resources\PendingEventResource;
use Illuminate\Support\Carbon;

class PendingEventsController extends Controller
{
    public function index(Request $request)
    {   
       if (!$request->has('pending_page')) {
            return redirect()->route('admin.events', ['pending_page' => 1] + $request->except('page'));
        }

        if (!$request->has('event_page')) {
            return redirect()->route('admin.events', ['event_page' => 1] + $request->except('page'));
        }

        $eventsPending = $this->getEventsPending($request);        
        $events = $this->getEvents($request);

        return Inertia::render('Admin/PendingEvents', [
            'pending_events' => PendingEventResource::collection($eventsPending)->response()->getData(true),

            'events' => PendingEventResource::collection($events)->response()->getData(true)
        ]);
    }

    public function showData(Request $request)
    {
        if (!$request->has('pending_page')) {
            return redirect()->route('admin.events.data', ['pending_page' => 1] + $request->except('page'));
        }

        if (!$request->has('event_page')) {
            return redirect()->route('admin.events.data', ['event_page' => 1] + $request->except('page'));
        }

        $eventsPending = $this->getEventsPending($request);        
        $events = $this->getEvents($request);
        

        return response()->json([
            'pending_events' => PendingEventResource::collection($eventsPending)->response()->getData(true),

            'events' => PendingEventResource::collection($events)->response()->getData(true)
        ]);
    }

    public function getEvents(Request $request)
    {      
        $query = Event::where('pending', false)->with([
            'hall.sections',
            'seats.section',
            'standingTickets.section',
        ]);

        $sortField = $request->input('event_sort_field', 'event_date');

        $sortDirection = match(strtolower($request->input('event_sort_dir', 'asc'))) {
            'desc' => 'desc',
            default => 'asc'
        };

        if ($request->filled('event_name')) {
            $query->where('event_name', 'like', '%' . $request->event_name . '%');
        }

        if ($request->filled('event_date')) {
                $query->whereDate('event_date', 
                Carbon::parse($request->event_date)->format('Y-m-d'));
        } else {
            if ($request->filled('event_date_from')) {
                $dateFrom = Carbon::parse($request->event_date_from)->format('Y-m-d');
                $query->whereDate('event_date', '>=', $dateFrom);
            }
        
            if ($request->filled('event_date_to')) {
                $dateTo = Carbon::parse($request->event_date_to)->format('Y-m-d');
                $query->whereDate('event_date', '<=', $dateTo);
            }
        }

        if ($request->filled('event_genres')) {
            $genreIds = is_array($request->event_genres) 
                ? $request->event_genres 
                : explode(',', $request->event_genres);
            
            $query->whereHas('genres', function($q) use ($genreIds) {
                $q->whereIn('genres.id', $genreIds);
            });
        }

        $events = $query->orderBy($sortField, $sortDirection)
                        ->paginate($perPage = 20, $columns = ['*'], $pagename = 'event_page')
                        ->appends($request->query());

        return $events;
    }

    public function getEventsPending(Request $request)
    {      
        $query = Event::where('pending', true)->with([
            'hall.sections',
            'seats.section',
            'standingTickets.section',
        ]);


        $sortField = $request->input('pending_sort_field', 'event_date');

        $sortDirection = match(strtolower($request->input('pending_sort_dir', 'asc'))) {
            'desc' => 'desc',
            default => 'asc'
        };

        if ($request->filled('pending_name')) {
            $query->where('event_name', 'like', '%' . $request->pending_name . '%');
        }

        if ($request->filled('pending_date')) {
                $query->whereDate('event_date', 
                Carbon::parse($request->pending_date)->format('Y-m-d'));
        } else {
            if ($request->filled('pending_date_from')) {
                $dateFrom = Carbon::parse($request->pending_date_from)->format('Y-m-d');
                $query->whereDate('event_date', '>=', $dateFrom);
            }
        
            if ($request->filled('pending_date_to')) {
                $dateTo = Carbon::parse($request->pending_date_to)->format('Y-m-d');
                $query->whereDate('event_date', '<=', $dateTo);
            }
        }

        if ($request->filled('pending_genres')) {
            $genreIds = is_array($request->pending_genres) 
                ? $request->event_genres 
                : explode(',', $request->pending_genres);
            
            $query->whereHas('genres', function($q) use ($genreIds) {
                $q->whereIn('genres.id', $genreIds);
            });
        }

        $events = $query->orderBy($sortField, $sortDirection)
                        ->paginate($perPage = 20, $columns = ['*'], $pagename = 'pending_page')
                        ->appends($request->query());

        return $events;
    }
}
