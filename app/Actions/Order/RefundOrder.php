<?php

namespace App\Actions\Order;

use App\Helper;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Services\PaymentProviders\PaymentProviderFactory;

class RefundOrder
{
    public function handle(int $orderItemId, float $amount, string $action, bool $buyerPaysForReturnPostage)
    {
        $orderItem = OrderItem::findOrFail($orderItemId);
        $status = $action === 'full_amount' ? 'refunded' : 'partial_refund';

        $paymentIntentId = (new CancelOrder())->handle($orderItem);

        $amountToRefund = $buyerPaysForReturnPostage === true ? $orderItem->shipping_price : 0;

        if ($action === 'partial_amount') {
            $subtotal = $orderItem->price * $orderItem->quantity;
            $commissionAmount = Helper::calculateCommission($subtotal);
            $amountToRefund += $amount + $commissionAmount;

        }

        if ($action === '' || $buyerPaysForReturnPostage === true) {
            $customer = $orderItem->order->customer;
            $customerId = $customer->external_customer_id;

            $paymentIntent = (new PaymentProviderFactory())
                ->getClass()
                ->getPaymentIntent($paymentIntentId);

            $paymentMethodId = $paymentIntent['payment_method'];

            $payment = (new PaymentProviderFactory())
                ->getClass()
                ->authorizePayment($amountToRefund, $customerId, $paymentMethodId);

            Transaction::where('order_id', $orderItem->order_id)
                ->where('seller_id', $orderItem->seller_id)
                ->update(['external_payment_id' => $payment['id']]);
        }

        if (!empty($status)) {
            OrderItem::where('id', $orderItemId)->update(['status' => $status, 'refunded_date' => now()]);
        }

        return $payment;
    }
}
