<?php

namespace App\Services\PaymentProviders;

use App\Models\Order;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\StripeClient;
use Stripe\Token;

class Stripe extends BaseProvider
{
    public function capture(Collection $orderLines, array $orderData)
    {
        $items = collect($this->formatLineItems($orderLines));
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        $order = Order::whereId($orderData['orderId'])->first();

        try {
            if (!isset($orderData['token'])) {
                dd('no');
                return false;
            }

            // Create a new Stripe customer.
            $customer = $stripe->customers->create([
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
                'source' => $orderData['token']
            ]);

            foreach ($items as $sellerId => $item) {

                $products = collect($item);

                $subtotal = $products->sum('price');
                $shipping = round($products->sum('shipping'), 2);
                $commission = $items->count() > 1 ? $orderData['commission'] / $items->count() : $orderData['commission'];
                $total = $subtotal + $shipping + $commission;

                if (Session::has('coupon')) { //TODO Needs to be done by seller
                    $total -= Session::get('coupon')['value'];
                }

                Log::info('subtotal: ' . $subtotal . ' shipping: ' . $shipping . ' comission: ' . $commission . ' total: ' . $total);

                $charge = $stripe->charges->create([
                    'customer' => $customer['id'],
                    'currency' => config('shop.currency_code', 'GBP'),
                    'amount' => round(($total * pow(10, 2)), 0),
                    'description' => 'Payment for order no ' . $order->id
                ]);

                $transactionData = [
                    'order_id' => $orderData['orderId'],
                    'seller_id' => $sellerId,
                    'status' => 'pending',
                    'payment_method' => 'card',
                    'customer_id' => Auth::id(),
                    'total' => $total,
                    'commission' => $commission,
                    'shipping' => $shipping,
                    'discount' => Session::has('coupon') ? Session::get('coupon')['value'] : 0,
                ];

                Transaction::create($transactionData);

                if ($charge['status'] == 'succeeded') {
                    $order->transaction()->update(['payment_status' => 'approved']);
                }
            }


        } catch (Exception $exception) {
            dd($exception->getMessage());
            return false;
        }

        return false;
    }

}
