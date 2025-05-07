<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryAttributes;
use App\Models\ProductAttribute;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = app(Generator::class);
        $productAttributes = ProductAttribute::all();

        $categoryAttributes = [
            'Clothing' => ['Condition', 'Color', 'Size'],
            'Electronics' => ['Color', 'Condition'],
            'Appliances' => ['Color', 'Condition'],
            'Men' => ['Condition', 'Color', 'Size'],
            'Women' => ['Condition', 'Color', 'Size'],
            'Kids' => ['Condition', 'Color', 'Size'],
        ];

        $categories = [
            [
                'parent_id' => 0,
                'name' => 'Clothing',
                'slug' => 'clothing',
                'image' => Str::replace('categories/', '', collect(Storage::disk('public')->files('categories'))->random()),
                'is_featured' => 1,
                'menu_status' => 1,
                'active' => 1,
                'description' => $faker->sentence(),
                'meta_title' => $faker->sentence(),
                'meta_keywords' => $faker->word(),
            ],
            [
                'parent_id' => 0,
                'name' => 'Electronics',
                'slug' => 'electronics',
                'image' => Str::replace('categories/', '', collect(Storage::disk('public')->files('categories'))->random()),
                'is_featured' => 1,
                'menu_status' => 1,
                'active' => 1,
                'description' => $faker->sentence(),
                'meta_title' => $faker->sentence(),
                'meta_keywords' => $faker->word(),
            ],
            [
                'parent_id' => 0,
                'name' => 'Appliances',
                'slug' => 'appliances',
                'image' => Str::replace('categories/', '', collect(Storage::disk('public')->files('categories'))->random()),
                'is_featured' => 1,
                'menu_status' => 1,
                'active' => 1,
                'description' => $faker->sentence(),
                'meta_title' => $faker->sentence(),
                'meta_keywords' => $faker->word(),
            ],
            [
                'parent_id' => 1,
                'name' => 'Men',
                'slug' => 'men',
                'image' => Str::replace('categories/', '', collect(Storage::disk('public')->files('categories'))->random()),
                'is_featured' => 1,
                'menu_status' => 1,
                'active' => 1,
                'description' => $faker->sentence(),
                'meta_title' => $faker->sentence(),
                'meta_keywords' => $faker->word(),
            ],
            [
                'parent_id' => 1,
                'name' => 'Women',
                'slug' => 'women',
                'image' => Str::replace('categories/', '', collect(Storage::disk('public')->files('categories'))->random()),
                'is_featured' => 1,
                'menu_status' => 1,
                'active' => 1,
                'description' => $faker->sentence(),
                'meta_title' => $faker->sentence(),
                'meta_keywords' => $faker->word(),
            ],
            [
                'parent_id' => 1,
                'name' => 'Kids',
                'slug' => 'kids',
                'image' => Str::replace('categories/', '', collect(Storage::disk('public')->files('categories'))->random()),
                'is_featured' => 1,
                'menu_status' => 1,
                'active' => 1,
                'description' => $faker->sentence(),
                'meta_title' => $faker->sentence(),
                'meta_keywords' => $faker->word(),
            ],
        ];

        foreach ($categories as $category) {
            $category = Category::create($category);

            if (array_key_exists($category['name'], $categoryAttributes)) {
                foreach ($categoryAttributes[$category['name']] as $key => $value) {
                    $attribute = $productAttributes->where('name', $value)->first()->id;

                    CategoryAttributes::create([
                        'category_id' => $category->id,
                        'attribute_id' => $attribute,
                        'active' => true,
                    ]);
                }
            }
        }
    }
}
