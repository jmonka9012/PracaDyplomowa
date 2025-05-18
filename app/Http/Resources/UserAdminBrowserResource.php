<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdminPanelOrgarnizerData;
class UserAdminBrowserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'full_name' => trim($this->first_name . ' ' . $this->last_name),
            'role' => $this->role,
            'total_tickets' => $this->totalTicketsCount(),
            'support_tickets' => $this->supportTicketsCount(),
        ];

        if ($this->relationLoaded('organizer') && $this->organizer) {
            $data['organizer'] = new AdminPanelOrgarnizerData($this->organizer);
        }

        return $data;
    }
}