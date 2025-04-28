<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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

    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'author_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
