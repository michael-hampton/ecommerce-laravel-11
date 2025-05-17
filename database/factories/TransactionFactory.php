<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Stripe\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer = User::factory()->create();
        $seller = User::factory()->create();
        $order = Order::factory()->create();

        return [
            'customer_id' => $customer->id,
            'seller_id' => $seller->id,
            'external_payment_id' => $this->faker->word(),
            'payment_method' => 'card',
            'total' => $this->faker->randomDigit(),
            'shipping' => $this->faker->randomDigit(),
            'discount' => 0,
            'commission' => $this->faker->randomDigit(),
            'order_id' => $order->id
        ];
    }
}
