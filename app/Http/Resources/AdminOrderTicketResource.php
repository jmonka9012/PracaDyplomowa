<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminOrderTicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ticket_id' => $this->id,
            'is_seat' => $this->is_seat,
            'seat_data' => $this->whenLoaded('seat', fn() => [
                'seat_id' => $this->seat->id,
                'number' => $this->seat->seat_number,
                'row' => $this->seat->seat_row,
                'price' => $this->seat->price,
                'section' => $this->when(
                    $this->seat->relationLoaded('section'),
                    fn() => new AdminOrderSectionResource($this->seat->section)
                )
            ]),
            'standing_ticket_data' => $this->whenLoaded('standingTicket', fn() => [
                'standing_id' => $this->standingTicket->id,
                'hall_section_id' => $this->standingTicket->hall_section_id,
                'price' => $this->standingTicket->price,
                'section' => $this->when(
                    $this->standingTicket->relationLoaded('section'),
                    fn() => new AdminOrderSectionResource($this->standingTicket->section)
                )
            ]),
        ];
    }
}