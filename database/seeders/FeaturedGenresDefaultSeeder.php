<?php

namespace Database\Seeders;

use App\Models\FeaturedGenre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Events\Genre;

class FeaturedGenresDefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Rock',
            'Metal',
            'Indie',
            'Punk',
            'Jazz'
        ];

        foreach($genres as $genreName){
            $genre = Genre::where('genre_name', $genreName)->firstOrFail();

            FeaturedGenre::create([
                'genre_id' => $genre->id,
                'image_path' => 'event_images/placeholder.jpg' 
            ]);
        }
    }
}
