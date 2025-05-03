<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Events\Event;
use App\Http\Resources\PendingEventResource;


class PendingEventsController extends Controller
{
    public function index()
    {   
        $events = Event::where('pending', true)->get();

        return Inertia::render('Admin/PendingEvents', [
            'pending_events' => PendingEventResource::collection($events)
        ]);
    }

    public function showData()
    {
        $events = Event::where('pending', true)->get();

        return response()->json([
            'pending_events' => PendingEventResource::collection($events)
        ]);
    }
}
