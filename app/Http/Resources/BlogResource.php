<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id Unique ID of the post
 * @property int $author_id FK to the Author's account
 * @property string $blog_post_name Name of the post
 * @property string $slug slug of the blog post used in the creation of the url
 * @property string $blog_post_url URL leading to the blog post
 * @property mixed $blog_post_type Type of blog post
 * @property string $thumbnail_path Image path of the thumbnail
 * @property \DateTime $created_at Creation date of the post
 * @property mixed $author Holds data about the author
 * @property string $blog_post_content content of the blog post
 */

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
