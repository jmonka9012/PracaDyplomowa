<?php

namespace App\Models;

use App\Models\EventSeats\EventSeat;
use App\Models\EventStandingTickets\EventStandingTicket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HallSection extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'hall_id',
        'section_name',
        'section_type',
        'col',
        'row',
        'capacity',
        'section_height',
        'section_width',
    ];

    public function hall(): BelongsTo
    {
        return $this->belongsTo(Hall::class, 'hall_id');
    }

    public static function booted()
    {
        static::saved(function ($section) {
            $section->hall->updateHallCapacity();
        });
        
        static::deleted(function ($section) {
            $section->hall->updateHallCapacity();
        });

        static::saving(function ($section) {
            if ($section->section_type === 'seat') {
                $section->capacity = $section->row * $section->col;
            }
        });
    }

    public function eventSeats()
    {
        return $this->hasMany(EventSeat::class, 'hall_section_id');
    }
    public function eventStandingTickets()
    {
        return $this->hasMany(EventStandingTicket::class, 'hall_section_id');
    }
}