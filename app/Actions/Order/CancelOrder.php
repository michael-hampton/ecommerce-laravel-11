<?php

namespace App\Actions\Order;

use App\Models\OrderItem;
use App\Models\Transaction;
use App\Services\PaymentProviders\PaymentProviderFactory;

class CancelOrder
{
    public function handle(OrderItem $orderItem): string
    {
        $transaction = Transaction::where('order_id', $orderItem->order_id)
            ->where('seller_id', $orderItem->seller_id)
            ->firstOrFail();

        $paymentIntentId = $transaction->external_payment_id;

        (new PaymentProviderFactory())
            ->getClass()
            ->cancelPaymentIntent($paymentIntentId);

        return $paymentIntentId;
    }
}
