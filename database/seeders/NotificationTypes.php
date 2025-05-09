<?php

namespace Database\Seeders;

use App\Models\NotificationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Product added to wishlist', 'description' => 'Send a notification when someone added your product to their wishlist.'],
            ['name' => 'Notification when item in your wishlist is sold', 'description' => 'Notification when item in your wishlist is sold'],
            ['name' => 'Product in wishlist is reduced', 'description' => 'Notification when the price on a product in your wishlist is reduced'],
            ['name' => 'Notification when feedback received', 'description' => 'Notification when someone leaves you a review'],
        ];

        foreach($types as $type) {
            NotificationType::create($type);
        }
    }
}
