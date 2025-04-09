<?php

namespace App\Models\Events;
use App\Models\Tickets\TicketArchived;


class EventArchived extends EventBase
{
    protected $table = 'events_archive';

    public function tickets()
    {
        return $this->hasMany(TicketArchived::class);
    }
}
