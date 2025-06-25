<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Events\Genre;

class FeaturedCategory extends Model
{
    protected $table = 'featured_categories';

    protected $fillable = [
        'genre_id',
        'image_path'
    ];

    
    public function genres()
    {
        return $this->hasOne(Genre::class);
    }
}
