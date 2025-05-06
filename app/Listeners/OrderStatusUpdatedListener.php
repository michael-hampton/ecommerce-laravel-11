<?php



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
    public function handle(OrderStatusUpdated $event): void
    {
        $email = $event->order->customer->email;

        OrderLog::create([
            'order_id' => $event->order->id,
            'courier_name' => $event->data['courier_id'],
            'tracking_number' => $event->data['tracking_number'],
            'status_to' => $event->data['status'],
        ]);

        Mail::to($email)->send(new OrderShipped([
            'email' => $email,
            'name' => $event->order->customer->name,
            'order_id' => $event->order->id,
            'order' => $event->order,
            'orderItems' => $event->orderItems,
            'currency' => config('shop.currency'),
        ]));
    }
}
