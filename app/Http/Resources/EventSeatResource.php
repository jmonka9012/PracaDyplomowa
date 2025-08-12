<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id unique ID of the seat
 * @property int $event_id unique ID of the event
 * @property int $hall_section_id unique ID of the hall section the seat is in
 * @property int $seat_row the row the seat is located in
 * @property int $seat_number the column the seat is located in
 * @property float $price the price of the seat for the particular event
 * @property mixed $status status of the seat, either one of : //TODO zrobić tu enuma
 *  available - the seat is free to be picked at the event's page
 *  reserved - someone is currently buying the seat but has not yet paid
 *  sold - the seat is sold 
 */
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
            'price' => number_format((float)$this->price, 2, '.', ''),
            'status' => $this->status,
            
        ];
    }
}
