<?php

namespace Database\Seeders;

use App\Models\Slide;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = app(Generator::class);

        for ($i = 0; $i < 10; $i++) {
            $product = [
                'title' => $faker->sentence(),
                'image' => Str::replace('slides/', '', collect(Storage::disk('public')->files('slides'))->random()),
                'subtitle' => $faker->sentence(),
                'link' => $faker->url(),
                'active' => $faker->boolean(),
                'link_text' => $faker->sentence(),
                'tags' => $faker->word(),
            ];

            Slide::create($product);
        }
    }
}
