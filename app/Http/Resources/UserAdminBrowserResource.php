<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\AdminPanelOrgarnizerData;

/**
 * @property int $id ID of the user account
 * @property string $name the name of the user account
 * @property string $email the email of the user
 * @property string $first_name the legal name of the user
 * @property string $last_name the legal last name of the user
 * @property \App\Enums\UserRole $role the role of the account, either one of : verified_user, unverified_user, admin, moderator, organizer, blog_author, redactor
 * @property mixed $organizer the database entry with the organizer's data if the user is an organizer
 */

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