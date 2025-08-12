<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id unique ID of the seat
 * @property int $event_id unique ID of the event
 * @property int $hall_section_id unique ID of the hall section the seat is in
 * @property float $price the price of the ticket for the particular event
 * @property int $capacity the capacity of the standing section
 * @property int $reserved the amount of people currently buying a ticket for this section that have not yet paid
 * @property int $sold the amount of tickets sold in this section for the particular event
 */
class EventStandingTicketResource extends JsonResource
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
            'price' => $this->price,
            'capacity' => $this->capacity,
            'sold' => $this->sold,
            'reserved' => $this->reserved
        ];
    }
}
