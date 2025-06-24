<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HallWithStatsResource extends JsonResource
{
    protected $enrichedSections;

    public function __construct($resource, $enrichedSections = null)
    {
        parent::__construct($resource);
        $this->enrichedSections = $enrichedSections;
    }

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
            'sections' => $this->enrichedSections !== null
                ? HallSectionWithStatsResource::collection($this->enrichedSections)
                : HallSectionWithStatsResource::collection($this->whenLoaded('sections')),
        ];
    }
}
