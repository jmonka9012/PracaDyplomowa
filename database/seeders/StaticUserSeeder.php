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
        $users = Config::get('users.admins');
        foreach ($users as &$user) {
            $user['password'] = Hash::make($user['password']);
            $user['created_at'] = now();
            $user['updated_at'] = now();
            $user['email_verified_at'] = now();
            $user['permission_level'] = UserRole::from($user['role'])->permissionLevel();
        }
        DB::table('users')->insert($users);
    }
}
