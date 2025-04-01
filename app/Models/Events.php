<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $fillable = [
        'event_name',
        'event_url',
        'event_date',
        'event_start',
        'event_end',
        'contact_email',
        'contact_email_additional',
        'event_description',
        'event_description_additional',
        'event_location',
        'image_path',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
