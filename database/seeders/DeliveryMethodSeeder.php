<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Courier;
use App\Models\DeliveryMethod;
use Illuminate\Database\Seeder;

class DeliveryMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $couriers = Courier::all();

        $countryIds = [243, 244, 245, 286, 287, 290, 297, 342, 412, 468];
        $sizes = ['Large' => 3.99, 'Medium' => 2.88, 'Small' => 1.99];

        foreach ($countryIds as $country) {
            foreach ($sizes as $key => $size) {
                DeliveryMethod::create(['name' => $key, 'price' => $size, 'country_id' => $country, 'courier_id' => $couriers->first()->id]);
            }
        }
    }
}
