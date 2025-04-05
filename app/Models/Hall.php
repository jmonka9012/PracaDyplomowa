<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hall extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'hall_name',
        'seat_capacity',
        'stand_capacity',
        'hall_price',
        'hall_width',
        'hall_height',
    ];

    public function getTotalCapacity(): int{
        return $this->seat_capacity + $this->stand_capacity;
    }

    public function seatSections(): HasMany{
        return $this->hasMany(HallSection::class)->where('section_type', 'seat');
    }

    public function standSections(): HasMany{
        return $this->hasMany(HallSection::class)->where('section_type', 'stand');
    }

    public function sections(): HasMany{
        return $this->hasMany(HallSection::class, 'hall_id');
    }

    public function updateHallCapacity(): void{
        $this->seat_capacity = $this->sections()
        ->where('section_type', 'seat')
        ->sum('capacity');

        $this->stand_capacity = $this->sections()
        ->where('section_type', 'stand')
        ->sum('capacity');
        $this->save();
    }

}
