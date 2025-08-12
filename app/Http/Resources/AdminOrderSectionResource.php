<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id Unique ID of the section
 * @property string $section_name Name of the section
 * @property int $capacity Capacity of the section
 * @property int $section_height Height of the section
 * @property int $section_width Width of the section
 */

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
