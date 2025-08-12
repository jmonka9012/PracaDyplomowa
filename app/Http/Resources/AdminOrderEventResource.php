<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id Unique ID of the event
 * @property string $event_name Name of the event
 * @property string $event_url Link for the event
 * @property \DateTime $event_date DateTime the event is scheduled for
 */

class AdminOrderEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'event_id' => $this->id,
            'name' => $this->event_name,
            'date' => $this->event_date->format('Y.m.d H:i:s'),
            'event_url' => $this->event_url
        ];
    }
}
