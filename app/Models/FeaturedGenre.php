<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Events\Genre;

class FeaturedGenre extends Model
{
    protected $table = 'featured_genres';

    protected $fillable = [
        'id',
        'genre_id',
        'image_path'
    ];

        protected $attributes = [
        'genre_id' => 0
    ];
    
    public function genres()
    {
        return $this->hasOne(Genre::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class, 'genre_id', 'id');
    }
}
