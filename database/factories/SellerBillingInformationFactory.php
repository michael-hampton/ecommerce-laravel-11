<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SellerBillingInformation>
 */
class SellerBillingInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seller = User::factory()->create();
        $country = Country::factory()->create();

        return [
            'city' => $this->faker->city(),
            'zip' => $this->faker->postcode(),
            'state' => $this->faker->city(),
            'address1' => $this->faker->address(),
            'address2' => $this->faker->address(),
            'country_id' => $country->id,
            'seller_id' => $seller->id,
        ];
    }
}
