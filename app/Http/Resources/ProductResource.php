<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => asset('images/products') . '/' . $this->image,
            'images' => collect(explode(',', $this->images))->map(function ($image) {
                return asset('images/products') . '/' . $image;
            }),
            'category' => $this->category,
            'brand' => $this->brand,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'regular_price' => $this->regular_price,
            'sale_price' => $this->sale_price,
            'SKU' => $this->SKU,
            'has_stock' => $this->stock_status === 'instock' ? true : false,
            'featured' => $this->featured,
            'quantity' => $this->quantity,
            'seller_id' => $this->seller_id,
            'category_id' => $this->category->has('parent') ? $this->category->parent_id : $this->category_id,
            'subcategory_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'product_attributes' => $this->productAttributes,
            'package_size' => $this->package_size
        ];
    }
}
