<?php

namespace App\Models\EventStandingTickets;

use App\Models\Events\EventArchived;

class EventStandingTicketArchived extends EventStandingTicketBase
{
    protected $table = 'event_standing_tickets_archive';

    public function event(){
        return $this->belongsTo(EventArchived::class);
    }
}
