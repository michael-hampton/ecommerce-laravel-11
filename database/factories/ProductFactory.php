<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->word();
        $user = User::factory()->create();
        $brand = Brand::factory()->create();
        $category = Category::factory()->create();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'image' => UploadedFile::fake()->image('file1.png', 600, 600),
            //'images' => [UploadedFile::fake()->image('file1.png', 600, 600)],
            'category_id' => $category->id,
            'brand_id' => $brand->id,
            'regular_price' => $this->faker->randomDigit(),
            'short_description' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(2),
            'quantity' => $this->faker->randomDigitNotNull(),
            'featured' => true,
            'stock_status' => 'instock',
            'seller_id' => $user->id,
            'package_size' => 'Large',
            'SKU' => $this->faker->ean13(),
        ];
    }
}
