<?php

namespace App\Models;

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
        'capacity'
    ];

    public function hall(): BelongsTo
    {
        return $this->belongsTo(Halls::class, 'hall_id');
    }
}