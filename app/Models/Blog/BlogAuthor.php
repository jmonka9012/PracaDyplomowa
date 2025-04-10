<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class BlogAuthor extends Model
{
    protected $fillable = [
        'user_id',
        'author_image_path',
        'about_me'      
    ];
}
