<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\AttributeValue;
use Illuminate\Database\Seeder;

class AttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributeValues = [
            ['name' => 'New', 'attribute_id' => 1],
            ['name' => 'Used', 'attribute_id' => 1],
            ['name' => 'Refurbished', 'attribute_id' => 1],
            ['name' => 'Red', 'attribute_id' => 2],
            ['name' => 'Yellow', 'attribute_id' => 2],
            ['name' => 'Orange', 'attribute_id' => 2],
            ['name' => 'Green', 'attribute_id' => 2],
            ['name' => 'Purple', 'attribute_id' => 2],
            ['name' => 'Large', 'attribute_id' => 3],
            ['name' => 'Small', 'attribute_id' => 3],
            ['name' => 'Medium', 'attribute_id' => 3],
        ];

        foreach ($attributeValues as $attributeValue) {
            AttributeValue::create($attributeValue);
        }
    }
}
