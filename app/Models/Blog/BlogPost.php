<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'blog_post_name',
        'blog_post_content',
        'thumbnail_path',        
    ];
}
