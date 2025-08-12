<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id ID of the support ticket
 * @property int $user_id ID of the user if it's a user's ticket (null if guest)
 * @property string $name the name of the person writing the ticket
 * @property string $email the email attached to the ticket
 * @property string $topic the topic of the ticket for quick recognition
 * @property string $message the message of the ticket
 * @property mixed $status status of the ticket either one of : //TODO enum file
 * in_progress - ticket is waiting to be resolved or is being resolved
 * closed - ticket closed
 * @property \DateTime $created_at Datetime the event entry was created
 */

class SupportTicketResource extends JsonResource
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
            'user_id' => $this->user_id,
            'name' => $this->name,
            'email' => $this->email,
            'topic' => $this->topic,
            'message' => $this->message,
            'status' => $this->status,
            'created_at' => $this->created_at->format('d.m.Y'),
        ];
    }
}
