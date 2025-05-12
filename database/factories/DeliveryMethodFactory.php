<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\Courier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeliveryMethod>
 */
class DeliveryMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $country = Country::factory()->create();
        $courier = Courier::factory()->create();

        return [
            'name' => $this->faker->name,
            'price' => $this->faker->numberBetween(1, 100),
            'tracking' => true,
            'courier_id' => $courier->id,
            'country_id' => $country->id
        ];
    }
}
