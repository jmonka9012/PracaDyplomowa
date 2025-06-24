<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
