<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $address = Address::factory()->create();

        return [
                'customer_id' => User::factory()->create()->id,
                'subtotal' => $this->faker->numberBetween(1, 100),
                'shipping' => $this->faker->numberBetween(1, 100),
                'total' => $this->faker->numberBetween(1, 100),
                'discount' => 0,
                'tax' => $this->faker->numberBetween(1, 100),
                'commission' => 2,
                'status' => 'ordered',
                'address_id' => $address->id,
            ];
    }
}
