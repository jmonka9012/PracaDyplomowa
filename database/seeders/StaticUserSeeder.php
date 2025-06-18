<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class StaticUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staticUsers = Config::get('users.admins');

        foreach ($staticUsers as $userData) {
            $user = User::factory()->create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
                'email_verified_at' => now(),

                'phone' => $userData['phone'] ?? null,
                'country' => $userData['country'] ?? null,
                'zip_code' => $userData['zip_code'] ?? null,
                'city' => $userData['city'] ?? null,
                'street' => $userData['street'] ?? null,
                'house_number' => $userData['house_number'] ?? null,

                'role' => $userData['role'],
                'permission_level' => UserRole::from($userData['role'])->permissionLevel(),
            ]);

            if ($userData['role'] === 'organizer') {
                DB::table('organizer_information')->insert([
                    'user_id' => $user->id,
                    'company_name' => $userData['first_name'].' '.$userData['last_name'],
                    'phone_number' => $userData['phone'] ?? '1234567890',
                    'tax_number' => $userData['tax_number'] ?? 'NIP123456',
                    'address_country' => $userData['country'] ?? 'PL',
                    'address_city' => $userData['city'] ?? 'Poznań',
                    'address_zip_code' => $userData['zip_code'] ?? '61-719',
                    'address_street' => $userData['street'] ?? 'Kutrzeby 10',
                    'bank_account_number' => $userData['bank_account_number'] ?? 'PL61109010140000071219812874',
                    'account_status' => 'verified',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}