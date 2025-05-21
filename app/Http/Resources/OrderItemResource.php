<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'status' => $this->status,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'tracking_number' => $this->tracking_number,
            'shipping' => $this->shipping_price,
            'courier_id' => $this->courier_id,
            'orderLogs' => $this->logs->map(fn ($item) => OrderLogResource::make($item)),
            'product' => ProductResource::make($this->product),
            'messages' => MessageResource::collection($this->messages),
        ];
    }
}
