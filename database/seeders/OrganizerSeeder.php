<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\OrganizerInformation;

class OrganizerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createOrganizersWithStatus('pending', 10);
        $this->createOrganizersWithStatus('verified', 10);
        $this->createOrganizersWithStatus('denied', 10);
    }


    private function createOrganizersWithStatus(?string $status, int $count): void
    {
        User::factory()
            ->count($count)
            ->create([
                'role' => 'organizer',
                'permission_level' => 4,
            ])
            ->each(function ($user) use ($status) {
                OrganizerInformation::factory()
                    ->when($status, fn($factory) => $factory->state(['account_status' => $status]))
                    ->create(['user_id' => $user->id]);
            });
    }
}
