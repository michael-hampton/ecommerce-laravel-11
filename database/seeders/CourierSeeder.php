<?php

namespace Database\Seeders;

use App\Models\Courier;
use Illuminate\Database\Seeder;

class CourierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Evri', 'countries_active' => '243,412,468'],
            ['name' => 'Yodel', 'countries_active' => '243,412,468'],
            ['name' => 'DPD', 'countries_active' => '243,412,468'],
            ['name' => 'Royal Mail', 'countries_active' => '243,412,468'],
        ];

        foreach ($categories as $category) {
            Courier::create($category);
        }
    }
}
