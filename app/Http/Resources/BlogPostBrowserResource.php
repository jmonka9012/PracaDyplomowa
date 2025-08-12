<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id Unique ID of the post
 * @property int $author_id FK to the Author's account
 * @property string $blog_post_name Name of the post
 * @property string $blog_post_url URL leading to the blog post
 * @property mixed $blog_post_type Type of blog post
 * @property string $thumbnail_path Image path of the thumbnail
 * @property \DateTime $created_at Creation date of the post
 * @property mixed $author Holds data about the author
 */

class BlogPostBrowserResource extends JsonResource
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
            'author_id' => $this->author_id,
            'blog_post_name' => $this->blog_post_name,
            'blog_post_url' => $this->blog_post_url,
            'blog_post_type' => $this->blog_post_type,
            'thumbnail_path' => $this->thumbnail_path,
            'blog_date' => $this->created_at->format('d.m.Y'),
            'author_name' => $this->author?->user 
                ? trim($this->author->user->first_name . ' ' . $this->author->user->last_name)
                : null,
        ];
    }
}
