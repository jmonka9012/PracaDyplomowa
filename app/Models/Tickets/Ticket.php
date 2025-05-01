<?php

namespace App\Models\Tickets;


use App\Models\User;
use App\Models\Events\Event;
use App\Models\EventSeats\EventSeat;
use App\Models\EventStandingTickets\EventStandingTicket;


class Ticket extends TicketBase
{
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function seat()
    {
        return $this->belongsTo(EventSeat::class, 'seat_id');
    }

    public function standingTicket()
    {
        return $this->belongsTo(EventStandingTicket::class, 'standing_id');
    }
}
