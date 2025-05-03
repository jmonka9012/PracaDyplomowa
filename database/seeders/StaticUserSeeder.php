<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;

class StaticUserSeeder extends Seeder
{
        /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = collect(Config::get('users.admins'))->map(function($user) {
            $user['password'] = Hash::make($user['password']);
            $user['created_at'] = now();
            $user['updated_at'] = now();
            $user['email_verified_at'] = now();
            $user['permission_level'] = UserRole::from($user['role'])->permissionLevel();
            return $user;
        })->toArray();

        DB::table('users')->insert($users);

        foreach (Config::get('users.admins') as $seeded) {
            if ($seeded['role'] === 'organizer') {
                $userRow = DB::table('users')->where('email', $seeded['email'])->first();

                DB::table('organizer_information')->insert([
                    'user_id'             => $userRow->id,
                    'company_name'        => $seeded['first_name'].' '.$seeded['last_name'], // or hard-code “Organizer Eventare”
                    'phone_number'        => '1234567890',
                    'tax_number'          => 'NIP123456',
                    'address_country'     => 'PL',
                    'address_city'        => 'Poznań',
                    'address_zip_code'    => '61-719',
                    'address_street'      => 'Kutrzeby 10',
                    'bank_account_number' => 'PL61109010140000071219812874',
                    'account_status'      => 'verified',
                    'created_at'          => now(),
                    'updated_at'          => now(),
                ]);
            }
        }
    }
}
