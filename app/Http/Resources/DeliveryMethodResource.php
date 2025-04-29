<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryMethodResource extends JsonResource
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
            'name' => $this->name,
            'price' => $this->price,
            'country_id' => $this->country_id,
            'tracking' => $this->tracking,
            'courier_id' => $this->courier_id,
            'courier' => CourierResource::make($this->courier)
        ];
    }
}
