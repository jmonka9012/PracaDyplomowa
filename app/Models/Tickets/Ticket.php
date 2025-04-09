<?php

namespace App\Models\Tickets;


use App\Models\User;
use App\Models\Events\Event;


class Ticket extends TicketBase
{
        protected $with = ['event','user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
