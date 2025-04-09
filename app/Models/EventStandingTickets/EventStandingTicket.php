<?php

namespace App\Models\EventStandingTickets;

use App\Models\Events\Event;

class EventStandingTicket extends EventStandingTicketBase
{
    protected $table = 'event_standing_tickets';

    public function event(){
        return $this->belongsTo(Event::class);
    }
}
