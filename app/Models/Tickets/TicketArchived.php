<?php

namespace App\Models\Tickets;

use App\Models\Events\EventArchived;
use App\Models\EventSeats\EventSeatArchived;
use App\Models\EventStandingTickets\EventStandingTicketArchived;
use App\Models\User;

class TicketArchived extends TicketBase
{
    protected $table = 'tickets_archive';

    public function event()
    {
        return $this->belongsTo(EventArchived::class);
    }
    public function seat()
    {
        return $this->belongsTo(EventSeatArchived::class, 'seat_id');
    }

    public function standingTicket()
    {
        return $this->belongsTo(EventStandingTicketArchived::class, 'standing_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

