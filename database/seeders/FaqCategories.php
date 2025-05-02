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
        $categories = [
            [
                'name' => 'General',
                'slug' => 'general',
                'icon' => 'fa-question',
            ],
            [
                'name' => 'Sellers',
                'slug' => 'sellers',
                'icon' => 'fa-store',
            ],
            [
                'name' => 'Buyers',
                'slug' => 'buyers',
                'icon' => 'fa-cart-shopping',
            ],
            [
                'name' => 'Delivery',
                'slug' => 'delivery',
                'icon'=> 'fa-truck',
            ]
        ];

        foreach ($categories as $category) {
            FaqCategory::create($category);
        }
    }
}
