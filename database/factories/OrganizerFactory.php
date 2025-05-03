<?php

namespace Database\Factories;

use App\Models\Organizer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizerFactory extends Factory
{
    protected $model = Organizer::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'company_name' => $this->faker->company,
            'phone_number' => $this->faker->phoneNumber,
            'tax_number' => $this->faker->unique()->numerify('##########'),
            'address_country' => $this->faker->countryCode,
            'address_zip_code' => $this->faker->postcode,
            'address_city' => $this->faker->city,
            'address_street' => $this->faker->streetAddress,
            'bank_account_number' => $this->faker->iban('PL'),
            'account_status' => $this->faker->randomElement(['pending', 'verified', 'awaiting clarification']),
        ];
    }
}