<?php

namespace App\Http\Resources;

use Illuminate\Support\Collection;

class OrderTotals
{
    public function toArray(Collection $transactions)
    {
        return [
            'shipping' => $transactions->sum('shipping'),
            'tax' => $transactions->sum('tax'),
            'commission' => $transactions->sum('commission'),
            'total' => $transactions->sum('total'),
            'discount' => $transactions->sum('discount'),
            'payment_method' => $transactions->first()->payment_method,
            'payment_status' => $transactions->first()->payment_status,
        ];
    }
}
