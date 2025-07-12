<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
