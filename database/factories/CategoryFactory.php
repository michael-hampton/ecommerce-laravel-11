<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $word = $this->faker->word();
        return [
            'name' => $word,
            'slug' => Str::slug($word),
            'deleted_at' => null,
            'image' => UploadedFile::fake()->image('file1.png', 600, 600)
        ];
    }
}
