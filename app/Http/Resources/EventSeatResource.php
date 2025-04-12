<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class EventSeatResource extends JsonResource
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
            'event_id' => $this->event_id,
            'hall_section_id' => $this->hall_section_id,
            'seat_row' => $this->seat_row,
            'seat_number' => $this->seat_number,
            'price' => $this->price,
            'status' => $this->status,
            
        ];
    }
}
