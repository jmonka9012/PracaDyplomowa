<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Events;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RequestEventController extends Controller
{
    public function index()
    {
        return Inertia::render('RequestEvent');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($request->hasFile('event-image')) {
            $folder = 'event-images/'.now()->format('Y/m/d');

            $imagePath = $request->file('event-image')->store($folder,'public');
        } 
        else {
            $imagePath = null;
        }

        $request->merge(['image-path' => $imagePath]);

        $validatedData = $request->validate([
            'event_name' => 'required|string|max:255|unique:events,event_name',
            'event_url' => 'string|max:255|unique:events,event_url',
            'event_date' => 'date|required',
            'event_start' => 'time|required',
            'event_end' => 'time|required',
            'contact_email' => 'string|max:255',
            'contact_email_additional' => 'string|max:255',
            'event_description' => 'max:65535',
            'event_description-additional' => 'max:65535',
            'event_location' => 'string|max:255',
            'image_path' => 'string|max:255|nullable',
        ], [
            'events_name.unique' => 'Istnieję już wydarzenia z tą nazwą',
            'events_name.max' => 'Nazwa wydarzenia jest zbyt długa',
            'event_slug.unique' => 'Istnieje już wydarzenia z tym URLem',
            'event_description.max' => 'Opis jest zbyt długi',
            'event_description_additional.max'=> 'Dodtakowe informacje są zbyt długie',

        ]);
        
        $event = Events::create([
            'event_name'=> $validatedData['event_name'],
            'event_url'=> $validatedData['event_url'],
            'event_date'=> $validatedData['event_date'],
            'event_start'=> $validatedData['event_start'],
            'event_end'=> $validatedData['event_end'],
            'contact_email'=> $validatedData['contact_email'],
            'contact_email_additional'=> $validatedData['contact_email_additional'],
            'event_location'=> $validatedData['event_location'],
            'image_path'=> $validatedData['image_path'],
        ]);

        return redirect()->route('home');
    }
}
