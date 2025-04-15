<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['parent_id' => 0, 'name' => 'Clothing', 'slug' => 'clothing'],
            ['parent_id' => 0, 'name' => 'Electronics', 'slug' => 'electronics'],
            ['parent_id' => 0, 'name' => 'Appliances', 'slug' => 'appliances'],
            ['parent_id' => 1, 'name' => 'Men', 'slug' => 'men'],
            ['parent_id' => 1, 'name' => 'Women', 'slug' => 'women'],
            ['parent_id' => 1, 'name' => 'Kids', 'slug' => 'kids'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
