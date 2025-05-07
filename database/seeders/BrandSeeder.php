<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            ['name' => 'Adidas', 'slug' => 'adidas', 'image' => '1743773280.png'],
            ['name' => 'Amazon', 'slug' => 'amazon', 'image' => '1743773271.png'],
            ['name' => 'Converse', 'slug' => 'converse', 'image' => '1743773263.png'],
            ['name' => 'Disney', 'slug' => 'disney', 'image' => '1743962173.png'],
            ['name' => 'Guci', 'slug' => 'guci', 'image' => '1744746051.png'],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
