<?php

namespace Database\Factories;

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
        return [
            'biography' => $this->faker->paragraph(),
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
