<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id unique ID of the hall section
 * @property int $hall_id unique ID of the hall the section belongs to
 * @property mixed $section_type TODO enum here, it is the type of section either seated or standing
 * @property int $col the column position of the section in the hall
 * @property int $row the row position of the section in the hall
 * @property int $capacity the capacity of the hall section
 * @property int $section_width the section's width in amount of seats
 * @property int $section_height the section's height in amount of seats
 */

class HallSectionResource extends JsonResource
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
            'hall_id' => $this->hall_id,
            'section_type' => $this->section_type,
            'col' => $this->col,
            'row' => $this->row,
            'capacity' => $this->capacity,
            'section_width' => $this->section_width,
            'section_height' => $this->section_height,
         ];
     }
}
