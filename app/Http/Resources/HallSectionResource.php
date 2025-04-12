<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
