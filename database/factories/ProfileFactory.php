<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        return [
            'user_id' => $user->id,
            'biography' => $this->faker->paragraph(),
            'external_customer_id' => $this->faker->word(),
            'external_account_id' => $this->faker->word(),
            'city' => $this->faker->city(),
            'zip' => $this->faker->postcode(),
            'state' => $this->faker->city(),
            'address1' => $this->faker->address(),
            'address2' => $this->faker->address(),
            'phone' => $this->faker->e164PhoneNumber(),
            'profile_picture' => UploadedFile::fake()->image('file1.png', 600, 600)
        ];
    }
}
