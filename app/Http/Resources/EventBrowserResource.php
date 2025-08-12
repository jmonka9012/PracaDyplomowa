<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $hall Database entry of Hall the event is set in
 * @property boolean $pending Status of the event, if true then the event is awaiting admin approval
 * @property int $id unique ID of the event
 * @property string $event_name name of the event
 * @property string $event_url event_url based on the slug
 * @property \DateTime $event_date DateTime the event is set to
 * @property \DateTime $event_start Hour the event starts at
 * @property \DateTime $event_end Hour the event ends at
 * @property string $image_path path to the event's thumbnail
 * @property mixed $genres database entry of the genre(s) the event is tagged with
 * @property mixed $seats Database entry of the seats in the section of the hall
 * @property mixed $standingTickets Database entry of the standing section of the hall 
 */

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
