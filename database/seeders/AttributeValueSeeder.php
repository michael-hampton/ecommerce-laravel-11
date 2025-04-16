<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributeValues = [
            ['name' => 'Large', 'attribute_id' => 1],
            ['name' => 'Small', 'attribute_id' => 1],
            ['name' => 'Medium', 'attribute_id' => 1],
            ['name' => 'New', 'attribute_id' => 2],
            ['name' => 'Used', 'attribute_id' => 2],
            ['name' => 'Refurbished', 'attribute_id' => 2],
            ['name' => 'Red', 'attribute_id' => 3],
            ['name' => 'Yellow', 'attribute_id' => 3],
            ['name' => 'Orange', 'attribute_id' => 3],
            ['name' => 'Green', 'attribute_id' => 3],
            ['name' => 'Purple', 'attribute_id' => 3],
            ['name' => 'Large', 'attribute_id' => 4],
            ['name' => 'Small', 'attribute_id' => 4],
            ['name' => 'Medium', 'attribute_id' => 4],
        ];

        foreach ($attributeValues as $attributeValue) {
            AttributeValue::create($attributeValue);
        }
    }
}
