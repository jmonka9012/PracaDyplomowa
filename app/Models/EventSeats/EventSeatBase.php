<?php

namespace App\Models\EventSeats;

use Illuminate\Database\Eloquent\Model;

abstract class EventSeatBase extends Model
{
    protected $fillable = [
        'event_id',
        'hall_section_id',
        'seat_row',
        'seat_number',
        'price',
        'status',
    ];

    public function getIsArchivedAttribute()
    {
        return $this->getTable() == 'event_seats_archive';
    }
}

