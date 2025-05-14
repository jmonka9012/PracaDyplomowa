<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAdminBrowserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'full_name' => trim($this->first_name . ' ' . $this->last_name),
            'role' => $this->role,

            'total_tickets' => $this->totalTicketsCount(),

            'support_tickets' => $this->supportTicketsCount(),
        ];
    }
}
