<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventBrowserAdminResource extends JsonResource
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
            'event_additional_url' => $this->event_additional_url,
            'slug' => $this->slug,
            'event_date' => $this->event_date,
            'event_start' => $this->event_start,
            'event_end' => $this->event_end,
            'contact_email' => $this->contact_email,
            'contact_email_additional' => $this->contact_email_additional,
            'event_description' => $this->event_description,
            'event_description_additional' => $this->event_description_additional,
            'event_location' => new HallResource($this->whenLoaded('hall')),
            'image_path' => $this->image_path,
            'pending' => $this->pending,
        ];
    }
}
