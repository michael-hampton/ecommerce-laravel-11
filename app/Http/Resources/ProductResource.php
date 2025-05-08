<?php

declare(strict_types=1);

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
            'active' => $this->active,
            'image' => asset('images/products').'/'.$this->image,
            'images' => !empty($this->images) ? collect(explode(',', $this->images))->map(fn (string $image): string => asset('images/products').'/'.$image) : '',
            'category' => $this->category,
            'brand' => $this->brand,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'regular_price' => $this->regular_price,
            'sale_price' => $this->sale_price,
            'SKU' => $this->SKU,
            'has_stock' => $this->stock_status === 'instock',
            'featured' => $this->featured,
            'quantity' => $this->quantity,
            'seller_id' => $this->seller_id,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->category_id,
            'brand_id' => $this->brand_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'product_attributes' => $this->productAttributes,
            'package_size' => $this->package_size,
            'sales' => $this->orderItems->where('seller_id', auth('sanctum')->user()->id)->sum('quantity'),
            'earnings' => round($this->orderItems->where('seller_id', auth('sanctum')->user()->id)->map(fn ($product, $key): int|float => $product->price * $product->quantity)->sum(), 2),
        ];
    }
}
