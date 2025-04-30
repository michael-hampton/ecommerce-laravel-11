<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;

class OrderTotals
{
    public function toArray(Collection $transactions, $orderItems)
    {
        $sellerOrderItems = $orderItems->where('seller_id', auth('sanctum')->id());

        return [
            'shipping' => $sellerOrderItems->sum('shipping_price'),
            'tax' => $transactions->sum('tax'),
            'commission' => $transactions->sum('commission'),
            'subtotal' => $sellerOrderItems->sum(function ($item) {
                return ($item->price * $item->quantity);
            }),
            'total' => $sellerOrderItems->sum(function ($item) {
                return $item->discount > 0 ? ($item->price * $item->quantity + $item->tax + $item->shipping_price) - $item->discount : $item->price * $item->quantity + $item->tax + $item->shipping_price;
            }),
            'discount' => $transactions->sum('discount'),
            'payment_method' => $transactions->first()->payment_method,
            'payment_status' => $transactions->first()->payment_status,
        ];
    }
}
