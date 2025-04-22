<?php

namespace App\Models\Blog;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;
    use HasSlug;
    protected $fillable = [
        'author_id',
        'blog_post_name',
        'blog_post_content',
        'thumbnail_path',
        'slug',
        'created_at',
        'updated_at'  
    ];
}
