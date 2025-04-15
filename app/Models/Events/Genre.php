<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genre extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'genres';

    protected $fillable = [
        'genre_name'
    ];
}
