<?php

namespace App\Models\Blog;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Blog\BlogAuthor;

class BlogPost extends Model
{
    use HasFactory;
    use HasSlug;
    protected $fillable = [
        'author_id',
        'blog_post_name',
        'blog_post_content',
        'blog_post_type',
        'thumbnail_path',
        'slug',
        'blog_post_url',
        'created_at',
        'updated_at'  
    ];

    public function author()
    {
        return $this->belongsTo(BlogAuthor::class, 'author_id');
    }

    public function getRelatedPosts()
    {
        return static::where('blog_post_type', $this->blog_post_type)
            ->where('id', '!=', $this->id)
            ->orderByRaw('ABS(DATEDIFF(created_at, ?))', [$this->created_at])
            ->take(3)
            ->get();
    }
}
