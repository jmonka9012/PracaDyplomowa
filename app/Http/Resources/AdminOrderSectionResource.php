<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminOrderSectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    // SectionResource.php
    public function toArray($request)
    {
        return [
            'section_id' => $this->id,
            'name' => $this->section_name,
            'capacity' => $this->capacity,
            'section_height' => $this->section_height,
            'section_width' => $this->section_width,
        ];
    }
    
}
