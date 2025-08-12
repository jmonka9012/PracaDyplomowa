<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id Unique ID of the ticket
 * @property boolean $is_seat Is the ticket for a seat
 * @property mixed $seat Holds information about the seat
 * @property mixed $standingTicket Holds information about the seat
 */
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
                'price' => number_format((float)$this->seat->price, 2, '.', ''),
                'section' => $this->when(
                    $this->seat->relationLoaded('section'),
                    fn() => new AdminOrderSectionResource($this->seat->section)
                )
            ]),
            'standing_ticket_data' => $this->whenLoaded('standingTicket', fn() => [
                'standing_id' => $this->standingTicket->id,
                'hall_section_id' => $this->standingTicket->hall_section_id,
                'price' => number_format((float)$this->standingTicket->price, 2, '.', ''),
                'section' => $this->when(
                    $this->standingTicket->relationLoaded('section'),
                    fn() => new AdminOrderSectionResource($this->standingTicket->section)
                )
            ]),
        ];
    }
}