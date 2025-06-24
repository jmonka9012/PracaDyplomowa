<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PendingEventResource extends JsonResource
{
    public function toArray($request)
    {
        $sections = $this->hall->sections ?? collect();

        $sectionsWithStats = $sections->map(function ($section) {
            $seats = $this->seats->where('hall_section_id', $section->id);
            $standingTickets = $this->standingTickets->where('hall_section_id', $section->id);

            $isStanding = $standingTickets->isNotEmpty();

            $section->type = $isStanding ? 'stand' : 'seat';
            $section->price = (string) ($isStanding
                ? $standingTickets->first()?->price
                : $seats->first()?->price);
            $section->spots_available = $isStanding
                ? $standingTickets->sum('available')
                : $seats->where('status', 'available')->count();
            $section->spots_sold = $isStanding
                ? $standingTickets->sum('sold')
                : $seats->where('status', 'sold')->count();
            $section->spots_reserved = $isStanding
                ? $standingTickets->sum('reserved')
                : $seats->where('status', 'reserved')->count();
            $section->total_sold_value = $isStanding
                ? $standingTickets->sum(fn ($t) => $t->sold * $t->price)
                : $seats->where('status', 'sold')->sum('price');

            return $section;
        });

        $totalSaleValue = $sectionsWithStats->sum('total_sold_value');

        if (!$this->pending && $this->relationLoaded('hall')) {
            $this->hall->setRelation('sections', $sectionsWithStats);
        }

        return [
            'id' => $this->id,
            'event_name' => $this->event_name,
            'total_sale_value' => $totalSaleValue,
            'event_additional_url' => $this->event_additional_url,
            'slug' => $this->slug,
            'event_url' => $this->event_url,
            'event_date' => $this->event_date->format('d.m.Y'),
            'event_start' => $this->event_start->format('H:i'),
            'event_end' => $this->event_end->format('H:i'),
            'contact_email' => $this->contact_email,
            'contact_email_additional' => $this->contact_email_additional,
            'event_description' => $this->event_description,
            'event_description_additional' => $this->event_description_additional,
            'event_location' => $this->relationLoaded('hall')
                ? new HallWithStatsResource($this->hall, $sectionsWithStats)
                : null,
            'image_path' => $this->image_path,
            'pending' => $this->pending,
        ];
    }
}
