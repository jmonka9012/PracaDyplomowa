<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id unique ID of the hall
 * @property string $hall_name name of the hall
 * @property int $seat_capacity the seated capacity of the hall
 * @property int $stand_capacity the standing capacity of the hall
 * @property float $hall_price the price for renting out the particular hall
 * @property float $hall_width the width of the hall counted in amount of sections
 * @property float $hall_height the height of the hall counted in amount of section
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\HallSection[] $sections the database entries of the sections in the hall
 */

class HallResource extends JsonResource
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
            'hall_name' => $this->hall_name,
            'seat_capacity' => $this->seat_capacity,
            'stand_capacity' => $this->stand_capacity,
            'hall_price' => $this->hall_price,
            'hall_width' => $this->hall_width,
            'hall_height' => $this->hall_height,
            'sections' => HallSectionResource::collection($this->whenLoaded('sections'))
        ];
    }
}
