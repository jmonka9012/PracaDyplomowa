<?php

namespace App\Models\Events;
use App\Models\Tickets\TicketArchived;


class EventArchived extends EventBase
{
    protected $table = 'events_archive';
    public $incrementing = false;

    public function tickets()
    {
        return $this->hasMany(TicketArchived::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'event_genres_archive');
    }
}
