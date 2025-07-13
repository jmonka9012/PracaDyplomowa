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
            'Rock' => 'demo/genres/rock.svg',
            'Metal' => 'demo/genres/metal.svg',
            'Indie' => 'demo/genres/indie.svg',
            'Rap' => 'demo/genres/rap.svg',
            'Jazz' => 'demo/genres/jazz.svg',
        ];

        foreach($genres as $genreName => $imagePath){
            $genre = Genre::where('genre_name', $genreName)->firstOrFail();

            FeaturedGenre::create([
                'genre_id' => $genre->id,
                'image_path' => $imagePath
            ]);
        }
    }
}
