<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSeat extends Model
{
    protected $fillable = [
        'event_id',
        'hall_section_id',
        'seat_row',
        'seat_number',
        'price',
        'status',
    ];
}
