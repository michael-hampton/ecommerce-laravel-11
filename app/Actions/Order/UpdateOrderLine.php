<?php

declare(strict_types=1);

namespace App\Actions\Order;

use App\Events\OrderStatusUpdated;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Repositories\Interfaces\IAddressRepository;
use App\Repositories\Interfaces\IOrderRepository;

class UpdateOrderLine
{
    public function handle(array $data, int $id)
    {
        $orderData = ['status' => $data['status']];

        if ($data['status'] === 'delivered') {
            $orderData['delivered_date'] = now();
        }

        if ($data['status'] === 'cancelled') {
            $orderData['cancelled_date'] = now();
        }

        if (! empty($data['tracking_number'])) {
            $orderData['tracking_number'] = $data['tracking_number'];
        }

        if ($data['courier_id']) {
            $orderData['courier_id'] = $data['courier_id'];
        }

        $orderItem = OrderItem::with('order')->whereId($id)->first();
        $order = $orderItem->order;

        $orderItem->update($orderData);

        if ($data['status'] === 'delivered') {
            $transactions = $order->transaction->where('seller_id', auth('sanctum')->user()->id);
            // $transaction->payment_status = $data['status'] === 'delivered' ? 'approved' : 'refunded';
            Transaction::whereIn('id', $transactions->pluck('id'))->update(['payment_status' => $data['status'] === 'delivered' ? 'approved' : 'refunded']);
        }

        event(new OrderStatusUpdated($order, $order->orderItems->where('id', $id)->all(), $data));

        return $orderItem;
    }
}
