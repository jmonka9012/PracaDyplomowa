<?php

namespace App\Models\EventSeats;

use App\Models\Events\Event;
use App\Models\HallSection;

class EventSeat extends EventSeatBase
{
    protected $table = 'event_seats';

    public function event(){
        return $this->belongsTo(Event::class);
    }
    
    public function section(){
        return $this->belongsTo(HallSection::class);
    }
}
