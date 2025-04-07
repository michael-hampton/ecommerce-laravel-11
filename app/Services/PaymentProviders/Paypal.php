<?php

namespace App\Services\PaymentProviders;

use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Throwable;

class Paypal extends BaseProvider
{
    public function capture(Collection $orderLines, array $orderData)
    {
        $provider = new PayPalClient();
        $paypalToken = $provider->getAccessToken();

        $items = collect($this->formatLineItems($orderLines));

        $purchaseUnits = [];

        foreach ($items as $sellerId => $item) {

            $products = collect($item);

            $subtotal = $products->sum('price');
            $shipping = round($products->sum('shipping'), 2);
            $commission = $items->count() > 1 ? $orderData['commission'] / $items->count() : $orderData['commission'];

            $total = $subtotal + $shipping + $commission;

            if (Session::has('coupon')) { //TODO Needs to be done by seller
                $total -= Session::get('coupon')['value'];
            }

            $products = $products->map(function ($item) {
                unset($item['price'], $item['shipping']);
                return $item;
            });

            $amounts = [
                'currency_code' => config('shop.currency_code', 'GBP'),
                'value' => round($total, 2),
                'breakdown' => [ //discount
                    'item_total' => [
                        'currency_code' => config('shop.currency_code', 'GBP'),
                        'value' => $subtotal,
                    ],
                    'shipping' => [
                        'currency_code' => config('shop.currency_code', 'GBP'),
                        'value' => $shipping,
                    ],
                    'insurance' => [
                        'currency_code' => config('shop.currency_code', 'GBP'),
                        'value' => (float)round($commission, 2),
                    ]
                ]
            ];

            if (Session::has('coupon')) {
                $amounts['breakdown']['discount'] = [
                    'currency_code' => config('shop.currency_code', 'GBP'),
                    'value' => (float)Session::get('coupon')['value'],
                ];
            }

            //tax total The total tax for all items. Required if the request includes purchase_units.items.tax. Must equal the sum of (items[].tax * items[].quantity) for all items. tax_total.value can not be a negative number.
            $purchaseUnits[] = [
                'invoice_id' => "{$orderData['orderId']}-{$sellerId}",
                'reference_id' => $sellerId,
                'amount' => $amounts,
                'items' => $products->toArray()
            ];

            $transactionData = [
                'order_id' => $orderData['orderId'],
                'seller_id' => $sellerId,
                'status' => 'pending',
                'payment_method' => 'paypal',
                'customer_id' => Auth::id(),
                'total' => $total,
                'commission' => $commission,
                'shipping' => $shipping,
                'discount' => Session::has('coupon') ? Session::get('coupon')['value'] : 0,
            ];

            Transaction::create($transactionData);
        }

        $provider->setApiCredentials(config('paypal'));

        try {
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('paypal.payment.success', ['orderId' => $orderData['orderId']]),
                    "cancel_url" => route('paypal.payment/cancel'),
                ],
                'purchase_units' => $purchaseUnits,
            ]);

            if (isset($response['error'])) {
                dd($response);
                return false;
            }

            if (isset($response['id']) && $response['id'] != null) {
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href'])->send();

                    }
                }

                dd($response);

                return false;
            }
        } catch (Exception $exception) {
            dd($exception->getMessage());
            return false;
        }


        return false;
    }


    /**
     * @param Request $request
     * @return bool
     * @throws Throwable
     */
    public function paymentSuccess(Request $request): bool
    {
        $provider = new PayPalClient;

        $provider->setApiCredentials(config('paypal'));

        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->query('token'));

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return true;
        }

        return false;
    }
}
