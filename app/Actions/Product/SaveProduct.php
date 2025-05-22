<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\WithdrawalEnum;
use App\Models\WithdrawalTypeEnum;
use App\Services\WithdrawalService;

class SaveProduct
{
    protected function saveAttributes(array $data, Product $product): void
    {
        $productAttributeValues = AttributeValue::all()->keyBy('id');

        foreach ($data as $attributeValueId) {

            $attributeValue = $productAttributeValues->get($attributeValueId);

            $data = [
                'product_attribute_id' => $attributeValue->attribute_id,
                'attribute_value_id' => $attributeValue->id,
                'product_id' => $product->id,
            ];

            $attributeValue = new ProductAttributeValue;
            $attributeValue->fill($data);
            $attributeValue->save();
        }
    }
}
