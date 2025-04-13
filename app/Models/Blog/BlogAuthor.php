<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogAuthor extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'author_image_path',
        'about_me',
        'created_at',  
        'updated_at'    
    ];
}
