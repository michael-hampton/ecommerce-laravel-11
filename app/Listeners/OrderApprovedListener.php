<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\OrderApproved;
use App\Http\Resources\OrderTotals;
use Illuminate\Support\Facades\Mail;

class OrderApprovedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderApproved $orderApproved): void
    {
        $email = $orderApproved->user->email;
        Mail::to($email)->send(new \App\Mail\OrderApproved([
            'email' => $email,
            'name' => $orderApproved->order->customer->name,
            'order_id' => $orderApproved->order->id,
            'order' => $orderApproved->order,
            'orderItems' => $orderApproved->orderItems,
            'currency' => config('shop.currency'),
            'totals' => (new OrderTotals)->toArray($orderApproved->order->transaction, $orderApproved->order->orderItems, $orderApproved->user->id),
        ]));
    }
}
