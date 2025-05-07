<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Support\Collection;

class OrderTotals
{
    public function toArray(Collection $transactions, $orderItems, ?int $sellerId = null): array
    {
        if ($sellerId === null) {
            $sellerId = auth('sanctum')->id();
        }

        $sellerOrderItems = $orderItems->where('seller_id', $sellerId);
        $sellerTransactions = $transactions->where('seller_id', $sellerId);

        return [
            'shipping' => $sellerOrderItems->sum('shipping_price'),
            'tax' => $sellerTransactions->sum('tax'),
            'commission' => $transactions->sum('commission'),
            'subtotal' => $sellerOrderItems->sum(fn ($item): int|float => $item->price * $item->quantity),
            'total' => $sellerOrderItems->sum(fn ($item): int|float => $item->discount > 0 ? ($item->price * $item->quantity + $item->tax + $item->shipping_price) - $item->discount : $item->price * $item->quantity + $item->tax + $item->shipping_price),
            'discount' => $sellerOrderItems->sum('discount'),
            'payment_method' => $sellerTransactions->first()->payment_method,
            'payment_status' => $sellerTransactions->first()->payment_status,
        ];
    }
}
