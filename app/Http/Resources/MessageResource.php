<?php



namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'seller_id' => $this->seller_id,
            'title' => $this->title,
            'comments' => CommentResource::collection($this->comments),
            'images' => collect(explode(',', $this->images))->map(function ($image) {
                return asset('images/messages/'.$image);
            }),
        ];
    }
}
