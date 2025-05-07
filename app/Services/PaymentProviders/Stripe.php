<?php

declare(strict_types=1);

namespace App\Services\PaymentProviders;

use App\Models\Order;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Customer;
use Stripe\StripeClient;

class Stripe extends BaseProvider
{
    public function capture(Collection $orderLines, array $orderData): bool
    {
        $items = collect($this->formatLineItems($orderLines));
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));

        $order = Order::whereId($orderData['orderId'])->first();

        try {
            if (! isset($orderData['token'])) {
                dd('no');

                return false;
            }

            // Create a new Stripe customer.
            $customer = $stripeClient->customers->create([
                'name' => $order->address->name,
                'email' => $order->customer->email,
                'phone' => $order->address->phone,
                'address' => [
                    'line1' => $order->address->address1,
                    'postal_code' => $order->address->zip,
                    'city' => $order->address->city,
                    'state' => $order->address->state,
                    'country' => $order->address->country,
                ],
                'shipping' => [
                    'name' => $order->address->name,
                    'address' => [
                        'line1' => $order->address->address1,
                        'postal_code' => $order->address->zip,
                        'city' => $order->address->city,
                        'state' => $order->address->state,
                        'country' => $order->address->country,
                    ],
                ],
                'source' => $orderData['token'],
            ]);

            foreach ($items as $sellerId => $item) {

                $products = collect($item);

                $subtotal = $products->sum('price');
                $shipping = round($products->sum('shipping'), 2);
                $commission = $items->count() > 1 ? $orderData['commission'] / $items->count() : $orderData['commission'];
                $total = $subtotal + $shipping + $commission;

                if (! empty($orderData['coupon']) && $orderData['coupon']->seller_id === $sellerId) {
                    $total -= $orderData['coupon']->value;
                }

                Log::info('subtotal: '.$subtotal.' shipping: '.$shipping.' comission: '.$commission.' total: '.$total);

                $charge = $stripeClient->charges->create([
                    'customer' => $customer['id'],
                    'currency' => config('shop.currency_code', 'GBP'),
                    'amount' => round(($total * pow(10, 2)), 0),
                    'description' => 'Payment for order no '.$order->id,
                ]);

                $transactionData = [
                    'order_id' => $orderData['orderId'],
                    'seller_id' => $sellerId,
                    'status' => 'in-progress',
                    'payment_method' => 'card',
                    'customer_id' => Auth::id(),
                    'total' => $total - $commission,
                    'commission' => $commission,
                    'shipping' => $shipping,
                    'discount' => empty($orderData['coupon']) ? 0 : $orderData['coupon']->value,
                ];

                Transaction::create($transactionData);

                if ($charge['status'] == 'succeeded') {
                    $order->transaction()->update(['payment_status' => 'pending']);
                }
            }

        } catch (Exception $exception) {
            dd($exception->getMessage());

            return false;
        }

        return false;
    }
}
