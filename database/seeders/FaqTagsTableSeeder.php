<?php

namespace Database\Seeders;

use App\Models\FaqTag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator;
use Illuminate\Support\Str;


class FaqTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);

        foreach(range(1, 30) as $id)
        {
            $word = $faker->word;
            FaqTag::create(['name' => $word, 'slug' => Str::slug($word)]);
        }
    }
}
