<?php

namespace App\Models\EventSeats;

use App\Models\Events\Event;

class EventSeat extends EventSeatBase
{
    protected $table = 'event_seats';

    public function event(){
        return $this->belongsTo(Event::class);
    }
}
