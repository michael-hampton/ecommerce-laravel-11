<?php

namespace App\Listeners;

use App\Events\OrderApproved;
use App\Http\Resources\OrderTotals;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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
    public function handle(OrderApproved $event): void
    {
        $email = $event->user->email;
        Mail::to($email)->send(new \App\Mail\OrderApproved([
            'email' => $email,
            'name' => $event->order->customer->name,
            'order_id' => $event->order->id,
            'order' => $event->order,
            'orderItems' => $event->orderItems,
            'currency' => config('shop.currency'),
            'totals' => (new OrderTotals())->toArray($$event->order->transaction, $$event->order->orderItems, $event->user->id),
        ]));
    }
}
