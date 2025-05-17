<?php

namespace Database\Seeders;

use App\Models\OrganizerInformation;
use Illuminate\Database\Seeder;
use App\Models\User;

class StaticOrganizerSeeder extends Seeder
{
    public function run(): void
    {
        $user1 = User::factory()->create([
            'name' => 'Organizer2',
            'email' => 'organizer2@example.com',
            'role' => 'organizer'
        ]);

        $user2 = User::factory()->create([
            'name' => 'Organizer3',
            'email' => 'organizer3@example.com',
            'role' => 'organizer'
        ]);


        OrganizerInformation::factory()->create([
            'user_id' => $user1->id,
            'company_name' => 'Pending INC.',
            'account_status' => 'pending',
        ]);

        OrganizerInformation::factory()->create([
            'user_id' => $user2->id,
            'company_name' => 'Denied LLC.',
            'account_status' => 'denied',
        ]);
    }
}
