<?php

namespace App\Models\EventStandingTickets;

use Illuminate\Database\Eloquent\Model;

abstract class EventStandingTicketBase extends Model
{
    protected $fillable = [
        'event_id',
        'hall_section_id',
        'price',
        'capacity',
        'sold',
    ];


    public function getIsArchivedAttribute()
    {
        return $this->getTable() == 'events_standing_tickets_archive';
    }
}
