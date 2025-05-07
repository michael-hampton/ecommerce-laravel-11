<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Faker\Generator;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = app(Generator::class);

        for ($i = 0; $i < 100; $i++) {
            $product = [
                'title' => $faker->sentence.' - '.$i,
                'message' => $faker->paragraph,
                'created_at' => now(),
                'seller_id' => 1,
                'user_id' => 1,
            ];

            $message = Post::create($product);

            for ($v = 0; $v < 25; $v++) {
                $product = [
                    'message' => $faker->paragraph,
                    'created_at' => now(),
                    'user_id' => 1,
                    'post_id' => $message->id,
                ];

                $comment = Comment::create($product);
            }
        }
    }
}
