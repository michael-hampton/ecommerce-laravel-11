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
            ['name' => 'Apple', 'slug' => 'apple', 'image' => '1744746051.png'],
            ['name' => 'Barbie', 'slug' => 'barbie', 'image' => '1744746051.png'],
            ['name' => 'Burberry', 'slug' => 'burberry', 'image' => '1744746051.png'],
            ['name' => 'Converse', 'slug' => 'converse', 'image' => '1744746051.png'],
            ['name' => 'Chicco', 'slug' => 'chicco', 'image' => '1744746051.png'],
            ['name' => 'Calvin Klein', 'slug' => 'calvin-klein', 'image' => '1744746051.png'],
            ['name' => 'Clarks', 'slug' => 'clarks', 'image' => '1744746051.png'],
            ['name' => 'Crocs', 'slug' => 'crocs', 'image' => '1744746051.png'],
            ['name' => 'Chanel', 'slug' => 'chanel', 'image' => '1744746051.png'],
            ['name' => 'Diesel', 'slug' => 'diesel', 'image' => '1744746051.png'],
            ['name' => 'Dickies', 'slug' => 'dickies', 'image' => '1744746051.png'],
            ['name' => 'Dr Martens', 'slug' => 'dr-maartens', 'image' => '1744746051.png'],
            ['name' => 'Elesse', 'slug' => 'elesse', 'image' => '1744746051.png'],
            ['name' => 'Fila', 'slug' => 'fila', 'image' => '1744746051.png'],
            ['name' => 'Fisher Price', 'slug' => 'fisher-price', 'image' => '1744746051.png'],
            ['name' => 'Funko', 'slug' => 'funko', 'image' => '1744746051.png'],
            ['name' => 'Guess', 'slug' => 'guess', 'image' => '1744746051.png'],
            ['name' => 'Geox', 'slug' => 'geox', 'image' => '1744746051.png'],
            ['name' => 'Hollister', 'slug' => 'hollister', 'image' => '1744746051.png'],
            ['name' => 'Harry Potter', 'slug' => 'harry-potter', 'image' => '1744746051.png'],
            ['name' => 'Hello Kitty', 'slug' => 'hello-kitty', 'image' => '1744746051.png'],
            ['name' => 'Hugo Boss', 'slug' => 'hugo-boss', 'image' => '1744746051.png'],
            ['name' => 'Kenzo', 'slug' => 'kenzo', 'image' => '1744746051.png'],
            ['name' => 'Kappa', 'slug' => 'kappa', 'image' => '1744746051.png'],
            ['name' => 'Levi\'s', 'slug' => 'levis', 'image' => '1744746051.png'],
            ['name' => 'Lacoste', 'slug' => 'lacoste', 'image' => '1744746051.png'],
            ['name' => 'Lego', 'slug' => 'lego', 'image' => '1744746051.png'],
            ['name' => 'Lee Cooper', 'slug' => 'lee-cooper', 'image' => '1744746051.png'],
            ['name' => 'Michael Kors', 'slug' => 'michael-kors', 'image' => '1744746051.png'],
            ['name' => 'Marvel', 'slug' => 'marvel', 'image' => '1744746051.png'],
            ['name' => 'Nike', 'slug' => 'nike', 'image' => '1744746051.png'],
            ['name' => 'Nintendo', 'slug' => 'nintendo', 'image' => '1744746051.png'],
            ['name' => 'New Balance', 'slug' => 'new-balance', 'image' => '1744746051.png'],
            ['name' => 'New Era', 'slug' => 'new-era', 'image' => '1744746051.png'],
            ['name' => 'Oasis', 'slug' => 'oasis', 'image' => '1744746051.png'],
            ['name' => 'Pokemon', 'slug' => 'pokemon', 'image' => '1744746051.png'],
            ['name' => 'Puma', 'slug' => 'puma', 'image' => '1744746051.png'],
            ['name' => 'Pepe Jeans', 'slug' => 'pepe-jeans', 'image' => '1744746051.png'],
            ['name' => 'Paw Patrol', 'slug' => 'paw-patrol', 'image' => '1744746051.png'],
            ['name' => 'Pandora', 'slug' => 'pandora', 'image' => '1744746051.png'],
            ['name' => 'Playmobil', 'slug' => 'playmobil', 'image' => '1744746051.png'],
            ['name' => 'Quiksilver', 'slug' => 'quiksilver', 'image' => '1744746051.png'],
            ['name' => 'Ralph Lauren', 'slug' => 'ralph-lauren', 'image' => '1744746051.png'],
            ['name' => 'Ray-Ban', 'slug' => 'ray-ban', 'image' => '1744746051.png'],
            ['name' => 'Reebok', 'slug' => 'reebok', 'image' => '1744746051.png'],
            ['name' => 'Ravensburger', 'slug' => 'ravensburger', 'image' => '1744746051.png'],
            ['name' => 'Superdry', 'slug' => 'superdry', 'image' => '1744746051.png'],
            ['name' => 'Tommy Hillfiger', 'slug' => 'tommy-hillfiger', 'image' => '1744746051.png'],
            ['name' => 'Timberland', 'slug' => 'timberland', 'image' => '1744746051.png'],
            ['name' => 'Ted Baker', 'slug' => 'ted-baker', 'image' => '1744746051.png'],
            ['name' => 'Under Armour', 'slug' => 'under-armour', 'image' => '1744746051.png'],
            ['name' => 'UGG', 'slug' => 'ugg', 'image' => '1744746051.png'],
            ['name' => 'Vans', 'slug' => 'vans', 'image' => '1744746051.png'],
            ['name' => 'VTech', 'slug' => 'vtech', 'image' => '1744746051.png'],
        ];

        $allBrands = Brand::all()->keyBy('name');
        foreach ($brands as $brand) {
            if ($allBrands->has(($brand['name']))) {
                continue;
            }
            Brand::create($brand);
        }
    }
}
