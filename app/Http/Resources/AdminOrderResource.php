<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id Unique ID of the order
 * @property string $order_number Unique number of the order
 * @property string $first_name First name of the customer
 * @property string $last_name Last name of the  customer
 * @property string $last_name Last name of the  customer
 * @property string $email Email of the  customer
 * @property float $total_price Total price of the order
 * @property \DateTime $created_at DateTime the order was created
 * @property \App\Enums\OrderPaymentStatus $payment_status status of the order : paid, cancelled or
 */
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
            'total_price' => number_format((float)$this->total_price, 2, '.', ''),
            'created_at' => $this->created_at->format('Y.m.d H:i:s'),
            'event' => new AdminOrderEventResource($this->whenLoaded('event')),
            'tickets' => AdminOrderTicketResource::collection($this->whenLoaded('tickets')),
        ];
    }
}
