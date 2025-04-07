<?php

namespace App\Models\Tickets;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

abstract class TicketBase extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'seat',
        'hall_section',
        'insured',
    ];
}
