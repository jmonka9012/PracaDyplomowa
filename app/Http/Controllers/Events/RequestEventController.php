<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Events;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Http\Requests\RequestEventRequest;

class RequestEventController extends Controller
{
    public function index()
    {
        return Inertia::render('RequestEvent');
    }

    public function store(RequestEventRequest $request): RedirectResponse
    {

        $validatedData = $request->validated(); 
        
        if ($request->hasFile('event_image')) {
            $eventName = Str::slug($request->input('event_name'));
            $folder = 'event_images/' . now()->format('Y/m') . '/' . $eventName;
        
            $imagePath = $request->file('event_image')->store($folder, 'public');
        } else {
            $imagePath = null;
        }
        

        $request->merge(['image_path' => $imagePath]);

        $event = Events::create([
            'event_name'=> $validatedData['event_name'],
            'event_url'=> $validatedData['event_url'],
            'event_date'=> $validatedData['event_date'],
            'event_start'=> $validatedData['event_start'],
            'event_end'=> $validatedData['event_end'],
            'contact_email'=> $validatedData['contact_email'],
            'contact_email_additional'=> $validatedData['contact_email_additional'],
            'event_location'=> $validatedData['event_location'],
            'event_description'=> $validatedData['event_description'],
            'event_description_additional'=> $validatedData['event_description_additional'],
            'image_path'=> $imagePath,
        ]);

        return redirect()->route('home');
    }
}
