<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventStandingTicket extends Model
{
    protected $fillable = [
        'event_id',
        'hall_section_id',
        'price',
        'capacity',
        'sold',
    ];
}
