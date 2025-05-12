<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'value' => $this->faker->numberBetween(1, 100),
            'cart_value' => $this->faker->numberBetween(1, 100),
            'type' => 'fixed',
            'expires_at' => $this->faker->date('Y-m-d'),
        ];
    }
}
