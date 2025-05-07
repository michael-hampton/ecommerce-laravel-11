<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Faker\Generator;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = app(Generator::class);

        for ($i = 0; $i < 10; $i++) {
            $product = [
                'code' => $faker->unique()->ean8(),
                'type' => 'fixed',
                'value' => $faker->randomFloat(2, 10, 100),
                'cart_value' => $faker->randomFloat(2, 10, 100),
                'expires_at' => $faker->date(),
                'seller_id' => $faker->numberBetween(1, 2),
                'usages' => $faker->numberBetween($min = 1, $max = 100),
            ];

            Coupon::create($product);
        }
    }
}
