<?php

namespace Database\Factories;

use Faker\Core\Number;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'password' => static::$password ??= Hash::make('12341234'),
            'remember_token' => Str::random(10),
            'phone' => $this->faker->phoneNumber,
            'country' => $this->faker->country,
            'zip_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'street' => $this->faker->streetName,
            'house_number' => $this->faker->buildingNumber,
            'company' => $this->faker->company,
            'tax_number' => $this->faker->unique()->numerify('##########'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
