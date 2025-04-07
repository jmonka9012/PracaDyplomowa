<?php

namespace App\Models\Events;


use Illuminate\Database\Eloquent\Model;

abstract class EventBase extends Model
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

    public function getIsArchivedAttribute()
    {
        return $this->getTable() == 'events_archive';
    }

}
