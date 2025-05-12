<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $country = Country::factory()->create();

        return [
            'customer_id' => $user->id,
            'name' => $this->faker->name(),
            'address1' => $this->faker->address(),
            'address2' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->city(),
            'zip' => $this->faker->postcode(),
            'country_id' => $country->id,
            'phone' => $this->faker->e164PhoneNumber()
        ];
    }
}
