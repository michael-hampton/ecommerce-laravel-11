<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class OrderResource extends JsonResource
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
            'customer' => UserResource::make($this->customer),
            'subtotal' => $this->subtotal(),
            'shipping' => $this->shipping(),
            'discount' => $this->discount,
            'tax' => $this->tax,
            'status' => Str::ucfirst($this->status),
            'orderItems' => $this->orderItems->where('seller_id', auth('sanctum')->id())->map(fn($item) => OrderItemResource::make($item))->flatten(),
            'delivered_date' => $this->delivered_date,
            'cancelled_date' => $this->cancelled_date,
            'total' => $this->total,
            'commission' => $this->commission,
            'tracking_number' => $this->tracking_number,
            'number_of_items' => $this->totalCount(),
            'order_date' => $this->created_at,
            'updated_at' => $this->updated_at,
            'courier' => CourierResource::make($this->courier),
        ];
    }
}
