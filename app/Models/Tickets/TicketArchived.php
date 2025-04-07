<?php

namespace App\Models\Tickets;

use App\Models\Events\EventArchived;
use App\Models\User;

class TicketArchived extends TicketBase
{
    protected $with = ['event','user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(EventArchived::class);
    }
}

