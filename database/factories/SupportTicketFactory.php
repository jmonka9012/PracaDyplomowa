<?php

namespace Database\Factories;

use App\Models\SupportTicket;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupportTicketFactory extends Factory
{
    protected $model = SupportTicket::class;

    public function definition(): array
    {
        return [
            'topic' => $this->faker->sentence(4),
            'message' => $this->faker->paragraph(),
            'email' => $this->faker->safeEmail(),
            'name' => $this->faker->name(),
            'user_id' => null,
        ];
    }
}
