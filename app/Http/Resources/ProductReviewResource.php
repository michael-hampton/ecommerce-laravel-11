<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'type' => 'product',
            'user' => UserResource::make($this->customer),
            'rating' => $this->rating,
            'created_at' => $this->created_at->diffForHumans(),
            'product' => ProductResource::make($this->commentable),
            'replies' => ProductReviewResource::make($this->replies),
        ];
    }
}
