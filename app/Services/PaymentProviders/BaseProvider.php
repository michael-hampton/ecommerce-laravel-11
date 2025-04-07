<?php

namespace App\Services\PaymentProviders;

class BaseProvider
{

    public function formatLineItems($orderLines)
    {
        $items = [];
        foreach ($orderLines as $item) {
            $lineTotal = $item->price * $item->qty;

            $items[$item->model->seller_id][] = [
                'name' => $item->model->name,
                'description' => $item->model->description,
                'sku' => $item->model->SKU,
                'quantity' => $item->qty,
                'shipping' => $item->shipping,
                'price' => $lineTotal,
                'unit_amount' => [
                    'currency_code' => config('shop.currency_code', 'GBP'),
                    'value' => $this->truncateNumber($lineTotal),
                ]
            ];
        }

        return $items;
    }

    protected function truncateNumber($number, $precision = 2)
    {
        // Zero causes issues, and no need to truncate
        if (0 == (int)$number) {
            return $number;
        }
        // Are we negative?
        $negative = $number / abs($number);
        // Cast the number to a positive to solve rounding
        $number = abs($number);
        // Calculate precision number for dividing / multiplying
        $precision = pow(10, $precision);
        // Run the math, re-applying the negative value to ensure returns correctly negative / positive
        return floor($number * $precision) / $precision * $negative;
    }
}
