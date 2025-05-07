<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'address' => AddressResource::make($this->address),
            'transactions' => $this->transaction->where('seller_id', auth('sanctum')->user()->id)->map(fn ($transaction) => TransactionResource::make($transaction)),
            'orderItems' => $this->orderItems->where('seller_id', auth('sanctum')->id())->map(fn ($item) => OrderItemResource::make($item))->flatten(),
            'orderLogs' => $this->logs->map(fn ($item) => OrderLogResource::make($item)),
            'totals' => (new OrderTotals)->toArray($this->transaction, $this->orderItems),
            'subtotal' => $this->subtotal,
            'shipping' => $this->shipping,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'status' => $this->status,
            'delivered_date' => $this->delivered_date,
            'cancelled_date' => $this->cancelled_date,
            'total' => $this->total,
            'commission' => $this->commission,
            'tracking_number' => $this->tracking_number,
            'courier_id' => $this->courier_id,
            'number_of_items' => $this->totalCount(),
            'order_date' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
