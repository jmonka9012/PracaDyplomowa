<?php

namespace App\Models\Tickets;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

abstract class TicketBase extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'is_guest',
        'user_id',
        'insured',
        'is_seat',
        'seat_id',
        'standing_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
