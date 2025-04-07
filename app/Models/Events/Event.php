<?php

namespace App\Models\Events;
use App\Models\Tickets\Ticket;


class Event extends EventBase
{
    protected $table = 'events';

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
