<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $hall Database entry of Hall the event is set in
 * @property mixed $seats Database entry of the seats in the section of the hall
 * @property mixed $standingTickets Database entry of the standing section of the hall 
 * @property boolean $pending Status of the event, if true then the event is awaiting admin approval
 * @property int $id unique ID of the event
 * @property string $event_name name of the event
 * @property string $slug slug used for the Event's URL generated using the event_name property
 * @property string $event_url event_url based on the slug
 * @property \DateTime $event_date DateTime the event is set to
 * @property \DateTime $event_start Hour the event starts at
 * @property \DateTime $event_end Hour the event ends at
 * @property string $contact_email The email for contact with the organizer
 * @property string $contact_email_additional The secondary email for contact with the organizer
 * @property string $event_description The description used in the event's entry for the users to read
 * @property string $event_description_additional Additional data about the event for the user like parking info
 * @property string $image_path path to the event's thumbnail
 * @property \DateTime $created_at Datetime the event entry was created
 * @property \DateTime $updated_at Datetime the event entry was last edited
 * @property mixed $genres database entry of the genre(s) the event is tagged with
 * @property mixed $organizer database entry of the organizer information
 */

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
            //'event_additional_url' => $this->event_additional_url,
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
            'organizer' => $this->whenLoaded('organizer', function () {
                return new AdminPanelOrgarnizerData($this->organizer);
            }),
        ];
    }
}
