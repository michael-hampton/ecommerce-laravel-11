<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CouponResource extends JsonResource
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
            'code' => $this->code,
            'type' => $this->type,
            'value' => $this->value,
            'categories' => CategoryResource::collection($this->categories())->resolve(),
            'brands' => BrandResource::collection($this->brands())->resolve(),
            'cart_value' => $this->cart_value,
            'expires_at' => $this->expires_at,
            'usages' => $this->usages,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
