<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slide>
 */
class SlideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tags' => $this->faker->word(),
            'title' => $this->faker->sentence(),
            'subtitle' => $this->faker->sentence(),
            'link' => 'http://www.bbc.co.uk',
            'image' => UploadedFile::fake()->image('file1.png', 600, 600)
        ];

    }
}
