<?php

declare(strict_types=1);

namespace App\Services\PaymentProviders;

class BaseProvider
{
    /**
     * @return \non-empty-list<array{name: mixed, description: mixed, sku: mixed, quantity: mixed, shipping: mixed, price: (float | int), unit_amount: array{currency_code: mixed, value: mixed}}>[]
     */
    public function formatLineItems($orderLines): array
    {
        $items = [];
        foreach ($orderLines as $orderLine) {
            $lineTotal = $orderLine->price * $orderLine->qty;

            $items[$orderLine->model->seller_id][] = [
                'name' => $orderLine->model->name,
                'description' => $orderLine->model->description,
                'sku' => $orderLine->model->SKU,
                'quantity' => $orderLine->qty,
                'shipping' => $orderLine->shipping,
                'price' => $lineTotal,
                'unit_amount' => [
                    'currency_code' => config('shop.currency_code', 'GBP'),
                    'value' => $this->truncateNumber($lineTotal),
                ],
            ];
        }

        return $items;
    }

    protected function truncateNumber($number, $precision = 2)
    {
        // Zero causes issues, and no need to truncate
        if ((int) $number == 0) {
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
