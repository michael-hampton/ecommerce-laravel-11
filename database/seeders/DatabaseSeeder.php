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
        $this->call(NotificationTypes::class);
        $this->call(FaqTagsTableSeeder::class);
        $this->call(FaqCategories::class);
        $this->call(FaqQuestionSeeder::class);
        $this->call(AttributeSeeder::class);
        $this->call(AttributeValueSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(CourierSeeder::class);
        $this->call(DeliveryMethodSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(CouponSeeder::class);
        $this->call(ShippingSeeder::class);
        $this->call(SlideSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ReviewSeeder::class);
        $this->call(MessageSeeder::class);

    }
}
