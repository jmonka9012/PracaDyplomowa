<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Events\Event;
use App\Http\Resources\EventBrowserResource;


class PendingEventsController extends Controller
{
    public function index()
    {   
        $events = Event::all();

        return Inertia::render('Admin/PendingEvents', [
            'events' => EventBrowserResource::collection($events)
        ]);
    }

    public function showData()
    {
        $events = Event::all();

        return response()->json([
            'events' => EventBrowserResource::collection($events)
        ]);
    }
}
