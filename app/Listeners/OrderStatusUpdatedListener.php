<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use App\Mail\OrderShipped;
use App\Models\OrderLog;
use Illuminate\Support\Facades\Mail;

class OrderStatusUpdatedListener
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
    public function handle(OrderStatusUpdated $orderStatusUpdated): void
    {
        $email = $orderStatusUpdated->order->customer->email;

        OrderLog::create([
            'order_id' => $orderStatusUpdated->order->id,
            'courier_name' => $orderStatusUpdated->data['courier_id'],
            'tracking_number' => $orderStatusUpdated->data['tracking_number'],
            'status_to' => $orderStatusUpdated->data['status'],
        ]);

        Mail::to($email)->send(new OrderShipped([
            'email' => $email,
            'name' => $orderStatusUpdated->order->customer->name,
            'order_id' => $orderStatusUpdated->order->id,
            'order' => $orderStatusUpdated->order,
            'orderItems' => $orderStatusUpdated->orderItems,
            'currency' => config('shop.currency'),
        ]));
    }
}
