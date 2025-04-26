<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\DeliveryMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shippings = [
            ['price' => 2.88, 'name' => 'Medium'],
            ['price' => 1.99, 'name' => 'Small'],
            ['price' => 3.99, 'name' => 'Large'],
            ['price' => 5.99, 'name' => 'Bulk'],
        ];

        foreach ($shippings as $shipping) {
            DeliveryMethod::create($shipping);
        }
    }
}
