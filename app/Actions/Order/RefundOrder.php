<?php

namespace App\Actions\Order;

use App\Helper;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Services\PaymentProviders\PaymentProviderFactory;

class RefundOrder
{
    public function handle(int $orderItemId, float $amount, string $action)
    {
        $orderItem = OrderItem::findOrFail($orderItemId);
        $status = '';

        $transaction = Transaction::where('order_id', $orderItem->order_id)
            ->where('seller_id', $orderItem->seller_id)
            ->firstOrFail();

        $paymentIntentId = $transaction->external_payment_id;

        $result = (new PaymentProviderFactory())
            ->getClass()
            ->cancelPaymentIntent($paymentIntentId);

        if ($action === 'full_amount') {
            $amountToRefund = ($orderItem->price * $orderItem->quantity) + $orderItem->shipping_price + $orderItem->commission;

            $status = 'refunded';
        }

        if ($action === 'partial_amount' || $action === 'no_shipping') {
            $status = 'partial_refund';
            $amountToRefund = $action === 'partial_amount' ? $amount : ($orderItem->price * $orderItem->quantity);
            $subtotal = $orderItem->price * $orderItem->quantity;
            $commissionAmount = Helper::calculateCommission($subtotal);
            $amountToRefund += $commissionAmount;

            $customer = $orderItem->order->customer;
            $customerId = $customer->external_customer_id;

            $paymentIntent = (new PaymentProviderFactory())
                ->getClass()
                ->getPaymentIntent($paymentIntentId);

            $paymentMethodId = $paymentIntent['payment_method'];

            $result = (new PaymentProviderFactory())
                ->getClass()
                ->authorizePayment($amountToRefund, $customerId, $paymentMethodId);
        }

        if (!empty($status)) {
            OrderItem::where('id', $orderItemId)->update(['status' => $status]);
        }

       return $result;
    }
}
