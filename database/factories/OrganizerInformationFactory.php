<?php

namespace Database\Factories;

use App\Models\OrganizerInformation;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class OrganizerInformationFactory extends Factory
{
    protected $model = OrganizerInformation::class;

    public function definition()
    {
        return [
            'user_id' => User::factory()->create([
                'role' => 'organizer',
                'permission_level' => 4,
            ]),

            
            'company_name' => $this->faker->company,
            'phone_number' => $this->faker->phoneNumber,
            'tax_number' => $this->faker->unique()->numerify('##########'),
            'address_country' => $this->faker->countryCode,
            'address_zip_code' => $this->faker->postcode,
            'address_city' => $this->faker->city,
            'address_street' => $this->faker->streetAddress,
            'bank_account_number' => $this->faker->iban('PL'),
            'account_status' => $this->faker->randomElement(['pending', 'verified', 'denied']),
        ];
    }
}