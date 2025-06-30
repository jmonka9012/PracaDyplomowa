<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GenreSeeder::class,
            StaticHallSeeder::class,
            StaticEventSeeder::class,
            StaticUserSeeder::class,
            StaticAuthorSeeder::class,
            StaticBlogPostSeeder::class,
            StaticOrganizerSeeder::class,
            FeaturedGenresDefaultSeeder::class
        ]);
    }
}
