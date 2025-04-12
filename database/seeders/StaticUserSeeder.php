<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $admins = Config::get('users.admins');
        foreach ($admins as &$admin) {
            $admin['password'] = Hash::make($admin['password']);
            $admin['created_at'] = now();
            $admin['updated_at'] = now();
            $admin['email_verified_at'] = now();
            $admin['permission_level'] = UserRole::ADMIN->permissionLevel();
        }
        DB::table('users')->insert($admins);
    }
}
