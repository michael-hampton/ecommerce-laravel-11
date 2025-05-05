<?php

namespace App\Actions\Order;

use App\Models\OrderItem;
use App\Models\User;
use App\Models\WithdrawalEnum;
use App\Models\WithdrawalTypeEnum;
use App\Repositories\Interfaces\IAddressRepository;
use App\Repositories\Interfaces\IOrderRepository;
use App\Services\WithdrawalService;
use Exception;

class ApproveOrder
{
    public function __construct(private IOrderRepository $repository, private IAddressRepository $addressRepository)
    {

    }


    public function handle(int $orderId, array $ids)
    {
        try {
            $orderItems = OrderItem::with('order')->whereIn('id', $ids)->get();
            $order = $orderItems->first()->order;
            $transactions = $order->transaction;
            $groupedBySeller = $orderItems->groupBy('seller_id');

            foreach ($groupedBySeller as $sellerId => $items) {
                $transaction = $transactions->where('seller_id', $sellerId)->first();

                $totals = $items->map(function (OrderItem $item) {
                    $total = $item->price * $item->quantity + $item->shipping_price;

                    if ($item->discount > 0) {
                        $total -= $item->discount;
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
               event(new \App\Events\OrderApproved( $order, $user, $items));

            }

            OrderItem::whereIn('id', $ids)->update(['approved_date' => now()]);

        } catch (Exception $e) {
            echo '' . $e->getMessage();
            die;
        }

        $order->update(['status' => 'complete']);

        return true;
    }
}
