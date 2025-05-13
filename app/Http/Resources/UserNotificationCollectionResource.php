<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserNotificationCollectionResource extends ResourceCollection
{
    private $extraData;

    public function __construct($resource, $extraData = [])
    {
        parent::__construct($resource);
        $this->extraData = $extraData;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
            'types' => $this->collection->map(fn ($player) => new NotificationTypeResource($player)),
            'user_types' => $this->extraData['user_notifications'] ?? [],
        ];
       
    }
}
