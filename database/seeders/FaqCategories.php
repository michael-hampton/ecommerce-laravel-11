<?php

namespace Database\Seeders;

use App\Models\FaqCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqCategories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [['name' => 'General', 'slug' => 'general'], ['name' => 'Sellers', 'slug' => 'sellers'], ['name' => 'Buyers', 'slug' => 'buyers'], ['name' => 'Delivery', 'slug' => 'delivery']];

        foreach ($categories as $category) {
            FaqCategory::create($category);
        }
    }
}
