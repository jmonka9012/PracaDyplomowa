<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
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
 */

class EventResource extends JsonResource
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
            'event_name' => $this->event_name,
            //'event_additional_url' => $this->event_additional_url,
            'slug' => $this->slug,
            //'event_url'=> $this->event_url,
            'event_date' => $this->event_date->format('d.m.Y'),
            'event_start' => $this->event_start->format('H:i'),
            'event_end' => $this->event_end->format('H:i'),
            'contact_email' => $this->contact_email,
            'contact_email_additional' => $this->contact_email_additional,
            'event_description' => $this->event_description,
            'event_description_additional' => $this->event_description_additional,
            'event_location' => new HallResource($this->whenLoaded('hall')),
            'image_path' => $this->image_path,
            'pending' => $this->pending,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'seats' => EventSeatResource::collection($this->whenLoaded('seats')),
            'standing_tickets' => EventStandingTicketResource::collection($this->whenLoaded('standingTickets')),
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
}
