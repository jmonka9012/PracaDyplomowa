<?php

namespace Database\Seeders;

use App\Models\Events\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Rock',
            'Avant-Garde',
            'Rock Alternatywny',
            'Rock Klasyczny',
            'Hard Rock',
            'Indie',
            'Garage Rock',
            'Grunge',
            'Rock Progressywny',
            'Rock Symfoniczny',
            'Rock Psychodeliczny',
            'Soft Rock',
            'Pop Rock',
            'Emo',
            'Glam Rock',
            'Rock Industrialny',
            'Crust Punk',
            'Hardcore Punk',
            'Folk Punk',
            'Pop Punk',
            'Post Hardcore',
            'Crossover Thrash',
            'Ska Punk',
            'Noise Rock',
            'Punk',
            'Metal',
            'Black Metal',
            'Blackened Death Metal',
            'War Metal',
            'First Wave Black Metal',
            'Second Wave Black Metal',
            'Ambient Black Metal',
            'Dungeon Synth',
            'Blackened Doom',
            'Depressive Suicidal Black Metal',
            'Blackened Crust',
            'Blackened Death-Doom',
            'Melodic Black Metal',
            'Symphonic Black Metal',
            'Viking Metal',
            'Blackgaze',
            'Black n\' roll',
            'Raw Black Metal',
            'Death Metal',
            'Melodic Death Metal',
            'Progressive Death Metal',
            'Brutal Death Metal',
            'Death-Doom',
            'Funeral Doom',
            'Industrial Death Metal',
            'Old School Death Metal',
            'Technical Death Metal',
            'Death n\' roll',
            'Deathgrind',
            'Grindcore',
            'Pornogrind',
            'Goregrind',
            'Electrogrind',
            'Industrial Metal',
            'Deathrash',
            'Deathcore',
            'Metalcore',
            'Power Metal',
            'Doom Metal',
            'Stoner Doom Metal',
            'Altertnative Metal',
            'Nu Metal',
            'Groove Metal',
            'Thrash Metal',
            'Heavy Metal',
            'NWOBHM',
            'Rap Metal',
            'Drone Metal',
            'Drone',
            'Sludge Metal',
            'Glam Metal',
            'Gothic Metal',
            'Rap',
            'Jazz'
        ];

        foreach($genres as $genre){
            Genre::create([
                'genre_name' => $genre
            ]);
        }
    }
}
