<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'user' => UserResource::make($this->user),
            'created_at' => $this->created_at->diffForHumans(),
            'message' => $this->message,
            'images' => collect(explode(',', $this->images))->map(fn($image) => asset('images/messages/'.$image)),
        ];
    }
}
