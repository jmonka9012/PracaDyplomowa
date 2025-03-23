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
            'event-name' => 'required|string|max:255|unique:events,event_name',
            'event-slug' => 'string|max:255|unique:events,event_url',
            'event-date' => 'date|required',
            'event-start' => 'time|required',
            'event-end' => 'time|required',
            'contact-email' => 'string|max:255',
            'contact-email_additional' => 'string|max:255',
            'event-description' => 'max:65535',
            'event-description-additional' => 'max:65535',
            'event-location' => 'string|max:255',
            'image-path' => 'string|max:255|nullable',
        ], [
            'events-name.unique' => 'Istnieję już wydarzenia z tą nazwą',
            'events-name.max' => 'Nazwa wydarzenia jest zbyt długa',
            'event-slug.unique' => 'Istnieje już wydarzenia z tym URLem',
            'event-description.max' => 'Opis jest zbyt długi',
            'event-description-additional.max'=> 'Dodtakowe informacje są zbyt długie',

        ]);
        
        $event = Events::create([
            'event_name'=> $validatedData['event-name'],
            'event_url'=> $validatedData['event-url'],
            'event_date'=> $validatedData['event-date'],
            'event_start'=> $validatedData['event-start'],
            'event_end'=> $validatedData['event-end'],
            'contact_email'=> $validatedData['contact-email'],
            'contact_email_additional'=> $validatedData['contact-email-additional'],
            'event_location'=> $validatedData['event-location'],
            'image_path'=> $validatedData['image-path'],
        ]);

        return redirect()->route('home');
    }
}
