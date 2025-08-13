<?php

namespace App\Models\Events;

use App\Models\Tickets\Ticket;
use App\Models\Tickets\TicketArchived;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
        protected $fillable = [
        'event_id',
        'order_number',
        'is_guest',
        'user_id',
        'insured',
        'total_price',
        'phone',
        'email',
        'country',
        'city',
        'street',
        'house_number',
        'zip_code',
        'payment_status',
        'first_name',
        'last_name',
        'last_interaction_time',
        'qr_data',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function TicketArchived()
    {
        return $this->hasMany(TicketArchived::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function getRouteKeyName()
    {
        return 'order_number';
    }
}
