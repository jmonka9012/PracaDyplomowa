<?php

namespace Database\Seeders;

use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SupportTicketSeeder extends Seeder
{
    public function run(): void
    {
        $topics = [
            'Problem z płatnością',
            'Zmiany w koncercie',
            'Problem z biletem',
            'Problem z założeniem konta',
            'Kiedy gra Bowie?',
            'Ile kosztuje piwo na miejscu?'
        ];

        $faker = Faker::create();

        SupportTicket::factory()->count(50)->create([
            'user_id' => null,
            'topic' => fake()->randomElement($topics)
        ]);

        User::factory()->count(50)->create()->each(function ($user) use ($topics) {
            SupportTicket::factory()->count(2)->create([
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->first_name . ' ' . $user->last_name,
                'topic' => fake()->randomElement($topics)
            ]);
        });
    }
}
