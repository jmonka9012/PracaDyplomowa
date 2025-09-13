<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Events\Event;
use App\Models\Hall;
use App\Models\EventSeats\EventSeat;
use App\Models\EventStandingTickets\EventStandingTicket;
use App\Models\Events\Genre;
use App\Models\OrganizerInformation;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Illuminate\Support\Str;
use App\Http\Requests\RequestEventRequest;
use Illuminate\Support\Facades\Auth;

class RequestEventController extends Controller
{
    public function index()
    {
        $halls = Hall::with('sections')->get();
        $genres = Genre::orderBy('id', 'asc')->get();

        return Inertia::render('Events/RequestEvent', [
            'halls' => $halls,
            'genres' => $genres
        ])->with('title', 'Zorganizuj Wydarzenie');;
    }

    public function showData()
    {
        $halls = Hall::with('sections')->get();
        $genres = Genre::orderBy('id', 'asc')->get();

        return response()->json([$halls, $genres]);
    }
    public function store(RequestEventRequest $request): RedirectResponse
    {

        $validatedData = $request->validated();

        $user = Auth::user();

        $organizer = $user->organizer;

        $genres = collect($validatedData['genre'])->pluck('value')->toArray();
        unset($validatedData['genre']);

        $sectionPrices = $validatedData['section_prices'];
        unset($validatedData['section_prices']);

        if ($request->hasFile('event_image')) {
            $eventName = Str::slug($request->input('event_name'));
            $folder = 'event_images/' . now()->format('Y/m') . '/' . $eventName;

            $imagePath = $request->file('event_image')->store($folder, 'public');
        } else {
            $imagePath = null;
        }


        $request->merge(['image_path' => $imagePath]);

        $event = Event::create([
            'event_name'=> $validatedData['event_name'],
            'organizer_id' => $organizer->id,
            //'event_additional_url'=> $validatedData['event_additional_url'],
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

        $event->genres()->attach($genres);

        $hall = Hall::with('sections')->find($validatedData['event_location']);

        foreach ($hall->sections as $section) {
            if($section->section_type == 'seat') {
                for($row = 1; $row <= $section->row; $row++){
                    for($col =1; $col <= $section->col; $col++){
                        EventSeat::create([
                            'hall_section_id'=> $section->id,
                            'event_id'=> $event->id,
                            'seat_row'=> $row,
                            'seat_number'=> $col,
                            'price'=> $sectionPrices[$section->id],
                            'status'=> 'available'
                        ]);
                    }
                }
            } else {
                EventStandingTicket::create([
                    'hall_section_id'=> $section->id,
                    'event_id'=> $event->id,
                    'capacity'=> $section->capacity,
                    'price' => $sectionPrices[$section->id],
                ]);
            }

        }
        return redirect()->route('home');
    }

}
