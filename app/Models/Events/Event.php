<?php

namespace App\Models\Events;
use App\Models\Tickets\Ticket;
use App\Models\EventSeats\EventSeat;
use App\Models\EventStandingTickets\EventStandingTicket;
use App\Models\Hall;

class Event extends EventBase
{
    protected $table = 'events';

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
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
}
