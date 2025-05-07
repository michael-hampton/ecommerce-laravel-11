<?php

declare(strict_types=1);

namespace App\Actions\Order;

use App\Models\OrderItem;
use App\Models\User;
use App\Models\WithdrawalEnum;
use App\Models\WithdrawalTypeEnum;
use App\Services\WithdrawalService;
use Exception;

class ApproveOrder
{
    public function handle(int $orderId, array $ids): bool
    {
        try {
            $orderItems = OrderItem::with('order')->whereIn('id', $ids)->get();
            $order = $orderItems->first()->order;
            $transactions = $order->transaction;
            $groupedBySeller = $orderItems->groupBy('seller_id');

            foreach ($groupedBySeller as $sellerId => $items) {
                $transaction = $transactions->where('seller_id', $sellerId)->first();

                $totals = $items->map(function (OrderItem $orderItem): int|float {
                    $total = $orderItem->price * $orderItem->quantity + $orderItem->shipping_price;

                    if ($orderItem->discount > 0) {
                        $total -= $orderItem->discount;
                    }

                    return $total;
                });

                (new WithdrawalService(
                    $sellerId,
                    $totals->sum(),
                    WithdrawalTypeEnum::OrderReceived,
                    WithdrawalEnum::Increase,
                    $transaction->id
                ))->updateBalance();

                $transaction->update(['payment_status' => 'approved']);

                $user = User::whereId($sellerId)->first();
                event(new \App\Events\OrderApproved($order, $user, $items));

            }

            OrderItem::whereIn('id', $ids)->update(['approved_date' => now()]);

        } catch (Exception $exception) {
            echo ''.$exception->getMessage();
            exit;
        }

        $order->update(['status' => 'complete']);

        return true;
    }
}
