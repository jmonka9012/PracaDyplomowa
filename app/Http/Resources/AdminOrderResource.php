<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_id' => $this->id,
            'order_number' => $this->order_number,
            'payment_status' => $this->payment_status,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'total_price' => $this->total_price,
            'created_at' => $this->created_at->format('Y.m.d H:i:s'),
            'event' => new AdminOrderEventResource($this->whenLoaded('event')),
            'tickets' => AdminOrderTicketResource::collection($this->whenLoaded('tickets')),
        ];
    }
}
