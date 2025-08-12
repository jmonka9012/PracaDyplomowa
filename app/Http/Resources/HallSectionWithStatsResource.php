<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id unique ID of the seat
 * @property string $section_name name of the section
 * @property mixed $type TODO enum here, it is the type of section either seated or standing
 * @property int $col the column position of the section in the hall
 * @property int $price price of the section
 * @property int $capacity capacity of the section 
 * @property int $spots_available amount of available seats
 * @property int $spots_sold amount of sold seats
 * @property int $spots_reserved amount of reserved but not paid yet seats
 * @property float $total_sold_value price of the section 
 */

class HallSectionWithStatsResource extends JsonResource
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
            'name' => $this->section_name ?? null,
            'type' => $this->type ?? null,
            'price' => $this->price ?? null,
            'capacity' => $this->capacity ?? null,
            'spots_available' => $this->spots_available ?? 0,
            'spots_sold' => $this->spots_sold ?? 0,
            'spots_reserved' => $this->spots_reserved ?? 0,
            'total_sold_value' => $this->total_sold_value ?? 0,
        ];
    }
}
