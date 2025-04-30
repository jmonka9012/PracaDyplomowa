<?php

namespace App\Models\Events;
use App\Models\Tickets\Ticket;
use App\Models\EventSeats\EventSeat;
use App\Models\EventStandingTickets\EventStandingTicket;
use App\Models\Hall;
use App\Models\Events\Genre;

class Event extends EventBase
{
    protected $table = 'events';

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'event_genres');
    }
    public function seats()
    {
        return $this->hasMany(EventSeat::class);
    }

    public function standingTickets()
    {
        return $this->hasMany(EventStandingTicket::class);
    }

    public function hall()
    {
        return $this->belongsTo(Hall::class, 'event_location', 'id');
    }

    public function getRelatedEvents()
    {
        $genreIds = $this->genres()->pluck('genres.id');

        if ($genreIds->isEmpty()){
            return collect();
        }

        return Event::whereHas('genres', function ($query) use ($genreIds) {
            $query->whereIn('genre_id', $genreIds);
        })
            ->where('id', '!=', $this->id)
            ->where('event_date', '>',$this->event_date)
            ->orderByRaw('ABS(DATEDIFF(event_date, ?))', [$this->event_date])
            ->take(3)
            ->get();
    }
    
    public function getEventGenres()
        {
            return $this->genres()->get();
        }
}
