<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use Faker\Generator;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = app(Generator::class);

        for ($i = 0; $i < 100; $i++) {
            $product = [
                'commentable_type' => Product::class,
                'commentable_id' => $faker->numberBetween(1, 99),
                'comment' => $faker->text(),
                'rating' => $faker->numberBetween(1, 5),
                'user_id' => 1
            ];

            $product = Review::create($product);
        }
    }
}
