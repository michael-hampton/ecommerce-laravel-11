<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Courier;
use Illuminate\Database\Seeder;

class CourierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = Country::where('shipping_active', true)->get();

        $categories = collect([
            ['name' => 'Evri', 'country_id' => 226],
            ['name' => 'Yodel', 'country_id' => 226],
            ['name' => 'DPD', 'country_id' => 226],
            ['name' => 'Royal Mail', 'country_id' => 226],
            ['name' => 'LBC Express', 'country_id' => 170],
            ['name' => 'DHL Express', 'country_id' => 170],
            ['name' => 'JRS Express', 'country_id' => 170],
            ['name' => 'UPS', 'country_id' => 170],
            ['name' => 'FastTrack', 'country_id' => 170],
        ]);

        $currentCouriers = Courier::all();

        foreach ($countries as $country) {
            $couriers = $categories->where('country_id', $country->id);
            if ($couriers->isEmpty()) {
                $couriers = $categories->where('country_id', 226);
            }

            foreach ($couriers as $courier) {
                $exists = $currentCouriers->where('name', $courier['name'])->where('country_id', $country->id);

                if ($exists->count() > 0) {
                    continue;
                }

                Courier::create(['country_id' => $country->id, 'name' => $courier['name']]);
            }
        }
    }
}
