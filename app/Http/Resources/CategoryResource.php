<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'active' => $this->active,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'description' => $this->description,
            'meta_keywords' => $this->meta_keywords,
            'slug' => $this->slug,
            'parent_id' => $this->parent_id,
            'attributes' => $this->attributes->pluck('attribute_id')->toArray(),
            'has_grandchild' => $this->hasGrandchildren(),
            'image' => asset('images/categories').'/'.$this->image,
            'products' => $this->products->count(),
            'subcategories' => $this->subcategories->toArray(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
