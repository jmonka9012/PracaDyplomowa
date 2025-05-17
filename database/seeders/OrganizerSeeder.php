<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrganizerInformation;

class OrganizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrganizerInformation::factory()
            ->count(50)
            ->create();
        
        OrganizerInformation::factory()->state([
            'account_status' => 'pending',
        ])->count(10)->create();

        OrganizerInformation::factory()->state([
            'account_status' => 'verified',
        ])->count(10)->create();

        OrganizerInformation::factory()->state([
            'account_status' => 'denied',
        ])->count(10)->create();
    }
}
