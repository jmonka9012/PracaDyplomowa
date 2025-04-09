<?php

namespace App\Models\EventSeats;

use App\Models\Events\EventArchived;

class EventSeatArchived extends EventSeatBase
{
    protected $table = 'event_seats_archive';

    public function eventArchive(){
        return $this->belongsTo(EventArchived::class);
    }
}