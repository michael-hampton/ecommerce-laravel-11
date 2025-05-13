<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Log;

class NotificationResource extends JsonResource
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
            'user' => UserResource::make($this->notifiable), 
            'created_at' => $this->created_at->diffForHumans(),
            'message' => $this->data['message'],
            'has_notification' => $this->user_notifications->has($this->id)
        ];
    }
}
