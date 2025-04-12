<?php

namespace App\Models\Events;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

abstract class EventBase extends Model
{
    use HasSlug;

    protected $casts = [
        'event_date' => 'date:Y-m-d',
        'event_start' => 'datetime:H:i',
        'event_end' => 'datetime:H:i',   
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $fillable = [
        'event_name',
        'event_additional_url',
        'event_date',
        'slug',
        'event_start',
        'event_end',
        'contact_email',
        'contact_email_additional',
        'event_description',
        'event_description_additional',
        'event_location',
        'image_path',
        'pending',
    ];

    public function getIsArchivedAttribute()
    {
        return $this->getTable() == 'events_archive';
    }

}
