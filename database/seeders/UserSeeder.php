<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // John Doe jest używany w unit testach
        $excludedName = "John Doe";
        $excludedEmail = ["john@example.com", "john2@example.com", "john3@example.com"];

        $usersCreated = 0;

        while ($usersCreated < 50) {
            $name = $faker->name;
            $email = $faker->unique()->safeEmail;
            $last_name = $faker->lastName;

            if ($name === $excludedName && $email === $excludedEmail) {
                continue;
            }

            User::create([
                'name' => $name,
                'email' => $email,
                'first_name'=> $name,
                'last_name'=> $last_name,
                'password' => Hash::make('12341234'),
                'email_verified_at'=> now(),
            ]);

            $usersCreated++;
        }
    }
}
