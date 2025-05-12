<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SellerBankDetails>
 */
class SellerBankDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seller = User::factory()->create();

        return [
            'card_name' => $this->faker->name(),
            'card_number' => $this->faker->creditCardNumber(),
            'card_expiry_date' => $this->faker->creditCardExpirationDateString(),
            'card_cvv' => '123',
            'type' => 'card',
            'seller_id' => $seller->id
        ];
    }
}
