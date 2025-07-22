<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventBrowserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lowestPrice = $this->getLowestPrice();

        return [
            'id' => $this->id,
            'event_name' => $this->event_name,
            'event_url'=> $this->event_url,
            'event_date' => $this->event_date->format('d.m.Y'),
            'event_start' => $this->event_start->format('H:i'),
            'event_end' => $this->event_end->format('H:i'),
            'event_location' => new HallResource($this->whenLoaded('hall')),
            'image_path' => $this->image_path,
            'lowest_price' => number_format((float)$lowestPrice, 2 , '.', ''),
            'genres' => $this->whenLoaded('genres', function () {
                return $this->genres->map(function ($genre) {
                    return [
                        'id' => $genre->id,
                        'name' => $genre->genre_name
                    ];
                });
            }),
        ];
    }

    protected function getLowestPrice(): ?float
    {
        $standingMin = $this->relationLoaded('standingTickets') 
            ? $this->standingTickets->min('price')
            : null;
        
        $seatedMin = $this->relationLoaded('seats') 
            ? $this->seats->min('price')
            : null;
        
        $prices = array_filter([$standingMin, $seatedMin], function($value) {
            return $value !== null;
        });
        
        return count($prices) ? min($prices) : null;
    }
}
