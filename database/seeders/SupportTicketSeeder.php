<?php

namespace Database\Seeders;

use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Database\Seeder;

class SupportTicketSeeder extends Seeder
{
    public function run(): void
    {
        SupportTicket::factory()->count(50)->create([
            'user_id' => null,
        ]);

        User::factory()->count(50)->create()->each(function ($user) {
            SupportTicket::factory()->count(2)->create([
                'user_id' => $user->id,
                'email' => $user->email,
                'name' => $user->first_name . ' ' . $user->last_name,
            ]);
        });
    }
}
