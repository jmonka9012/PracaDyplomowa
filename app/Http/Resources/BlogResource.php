<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'blog_post_name' => $this->blog_post_name,
            'slug' => $this->slug,
            'blog_post_url' => $this->blog_post_url,
            'thumbnail_path' => $this->thumbnail_path,
            'blog_post_content' => $this->blog_post_content,
            'updated_at' => $this->created_at->format('d.m.Y'),
            'blog_post_type' => $this->blog_post_type,
            'author' => new AuthorResource($this->whenLoaded('author')),
        ];
    }
}
