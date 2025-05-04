<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\OrderConfirmation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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
    public function handle(OrderCreated $event): void
    {
        $email = $event->order->customer->email;
        Mail::to($email)->send(new OrderConfirmation([
            'email' => $email,
            'name' => $event->order->customer->name,
            'order_id' => $event->order->id,
            'order' => $event->order,
            'orderItems' => $event->order->orderItems,
            'currency' => config('shop.currency'),
        ]));
    }
}
