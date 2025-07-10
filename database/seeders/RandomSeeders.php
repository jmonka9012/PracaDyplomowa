<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RandomSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            BlogPostSeeder::class,
            EventSeeder::class,
            OrganizerSeeder::class,
            SupportTicketSeeder::class,
            UserSeeder::class,
            OrderSeeder::class
        ]);
    }
}
