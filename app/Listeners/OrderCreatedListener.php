<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Mail;

class OrderCreatedListener
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
    public function handle(OrderCreated $orderCreated): void
    {
        $email = $orderCreated->order->customer->email;
        Mail::to($email)->send(new OrderConfirmation([
            'email' => $email,
            'name' => $orderCreated->order->customer->name,
            'order_id' => $orderCreated->order->id,
            'order' => $orderCreated->order,
            'orderItems' => $orderCreated->order->orderItems,
            'currency' => config('shop.currency'),
        ]));
    }
}
