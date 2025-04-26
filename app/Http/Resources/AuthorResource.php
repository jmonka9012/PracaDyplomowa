<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */// AuthorResource.php
    public function toArray(Request $request): array
    {
        return [
            'author_image_path' => $this->author_image_path,
            'about_me' => $this->about_me,
            'author_name' => $this->whenLoaded('user', function () {
                return trim(string: $this->user->first_name . ' ' . $this->user->last_name);
            }),
        ];
    }
}
