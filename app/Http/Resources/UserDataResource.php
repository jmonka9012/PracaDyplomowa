<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id ID of the user account
 * @property string $name the name of the user account
 * @property string $email the email of the user
 * @property string $first_name the legal name of the user
 * @property string $last_name the legal last name of the user
 * @property \App\Enums\UserRole $role the role of the account, either one of : verified_user, unverified_user, admin, moderator, organizer, blog_author, redactor
 * @property \DateTime $created_at Datetime the user account was created
 * @property \DateTime $updated_at Datetime the user account was last edited
 */

class UserDataResource extends JsonResource
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
           'first_name' => $this->first_name,
           'last_name' => $this->last_name,
           'role' => $this->role,
           'created_at' => $this->created_at->format('d.m.Y'),
           'updated_at' => $this->updated_at->format('d.m.Y'),
        ];
    }
}
