<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductAttributeValue;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = app(Generator::class);

        for ($i = 0; $i < 100; $i++) {
            $product = [
                'category_id' => $faker->numberBetween(1, 4),
                'brand_id' => $faker->numberBetween(1, 5),
                'short_description' => $faker->text(),
                'description' => $faker->text(),
                'regular_price' => $faker->randomFloat(2, 10, 100),
                'sale_price' => $faker->randomFloat(2, 10, 100),
                'SKU' => $faker->unique()->ean8(),
                'stock_status' => 'instock',
                'featured' => $faker->boolean(),
                'quantity' => 100,
                'seller_id' => $faker->numberBetween(1, 2),
                'name' => $faker->word(),
                'slug' => $faker->slug(),
                'image' => Str::replace('products/', '', collect(Storage::disk('public')->files('products'))->random()),
            ];

            $product = Product::create($product);

            ProductAttributeValue::create(['product_attribute_id' => 1, 'attribute_value_id' => 1, 'product_id' => $product->id]);
        }
    }
}
