<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategorySeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(AttributeSeeder::class);
        $this->call(AttributeValueSeeder::class);
        $this->call(CouponSeeder::class);
        $this->call(ShippingSeeder::class);
        $this->call(SlideSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ReviewSeeder::class);

    }
}
