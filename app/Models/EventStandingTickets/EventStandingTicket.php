<?php

namespace App\Models\EventStandingTickets;

use App\Models\Events\Event;
use App\Models\HallSection;

class EventStandingTicket extends EventStandingTicketBase
{
    protected $table = 'event_standing_tickets';

    public function event(){
        return $this->belongsTo(Event::class);
    }

     public function section(){
        return $this->belongsTo(HallSection::class);
    }
}
