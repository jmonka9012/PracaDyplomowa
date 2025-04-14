<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventBrowserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'event_name' => $this->event_name,
            'slug' => $this->slug,
            'event_url'=> $this->event_url,
            'event_date' => $this->event_date,
            'event_location' => new HallResource($this->whenLoaded('hall')),
            'image_path' => $this->image_path,
        ];
    }
}
