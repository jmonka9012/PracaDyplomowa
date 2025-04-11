<?php

namespace App\Http\Controllers\Events;

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
        return Inertia::render('EventSingle', [
            'event' => new EventResource($event) // This is correct
        ]);
    }
}
