<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()
            ->count(50)
            ->create()
            ->each(function ($user) {
                // John Doe jest uzywany w testach
                if ($user->name === 'John Doe') {
                    $user->update([
                        'name' => 'Generated ' . $user->name,
                        'first_name' => 'Generated ' . $user->first_name,
                    ]);
                }
            });
    }
}