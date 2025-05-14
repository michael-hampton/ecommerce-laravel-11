<?php

declare(strict_types=1);

namespace App\Services\PaymentProviders;

use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Throwable;

class Paypal extends BaseProvider
{
    public function capture(Collection $orderLines, array $orderData)
    {
        $payPal = new PayPalClient;
        $payPal->getAccessToken();

        $items = collect($this->formatLineItems($orderLines));

        $purchaseUnits = [];

        foreach ($items as $sellerId => $item) {

            $products = collect($item);

            $subtotal = $products->sum('price');
            $shipping = round($products->sum('shipping'), 2);
            $commission = $items->count() > 1 ? $orderData['commission'] / $items->count() : $orderData['commission'];

            $total = $subtotal + $shipping + $commission;

            if (! empty($orderData['coupon']) && $orderData['coupon']->seller_id === $sellerId) {
                $total -= $orderData['coupon']->value;
            }


            $products = $products->map(function (array $item): array {
                unset($item['price'], $item['shipping']);

                return $item;
            });

            $amounts = [
                'currency_code' => config('shop.currency_code', 'GBP'),
                'value' => round($total, 2),
                'breakdown' => [ // discount
                    'item_total' => [
                        'currency_code' => config('shop.currency_code', 'GBP'),
                        'value' => round($subtotal, 2),
                    ],
                    'shipping' => [
                        'currency_code' => config('shop.currency_code', 'GBP'),
                        'value' => round($shipping, 2),
                    ],
                    'insurance' => [
                        'currency_code' => config('shop.currency_code', 'GBP'),
                        'value' => round($commission, 2),
                    ],
                ],
            ];

            if (! empty($orderData['coupon'])) {
                $amounts['breakdown']['discount'] = [
                    'currency_code' => config('shop.currency_code', 'GBP'),
                    'value' => (float) $orderData['coupon']->value,
                ];
            }

            // tax total The total tax for all items. Required if the request includes purchase_units.items.tax. Must equal the sum of (items[].tax * items[].quantity) for all items. tax_total.value can not be a negative number.
            $purchaseUnits[] = [
                'invoice_id' => sprintf('%s-%s', $orderData['orderId'], $sellerId),
                'reference_id' => $sellerId,
                'amount' => $amounts,
                'items' => $products->toArray(),
            ];

            // $transactionData = [
            //     'order_id' => $orderData['orderId'],
            //     'seller_id' => $sellerId,
            //     'status' => 'in-progress',
            //     'payment_method' => 'paypal',
            //     'customer_id' => Auth::id(),
            //     'total' => $total - $commission,
            //     'commission' => $commission,
            //     'shipping' => $shipping,
            //     'discount' => empty($orderData['coupon']) ? 0 : $orderData['coupon']->value,
            // ];

            // Transaction::create($transactionData);
        }

        //   echo '<pre>';
        //     print_r($purchaseUnits);
        //     die;

        $payPal->setApiCredentials(config('paypal'));

        try {
            $response = $payPal->createOrder([
                'intent' => 'CAPTURE',
                'application_context' => [
                    'return_url' => route('paypal.payment.success', ['orderId' => $orderData['orderId']]),
                    'cancel_url' => route('paypal.payment/cancel'),
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
     * @throws Throwable
     */
    public function paymentSuccess(Request $request): bool
    {
        $payPal = new PayPalClient;

        $payPal->setApiCredentials(config('paypal'));

        $payPal->getAccessToken();

        $response = $payPal->capturePaymentOrder($request->query('token'));

        return isset($response['status']) && $response['status'] == 'COMPLETED';
    }
}
