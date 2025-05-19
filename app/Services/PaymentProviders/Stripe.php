<?php

declare(strict_types=1);

namespace App\Services\PaymentProviders;

use App\Models\Country;
use App\Models\Order;
use App\Models\Profile;
use App\Models\SellerBankDetails;
use App\Models\Transaction;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Account;
use Stripe\BankAccount;
use Stripe\Card;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\StripeClient;

class Stripe extends BaseProvider
{
    public function capture(Collection $orderLines, array $orderData): bool
    {
        $items = collect($this->formatLineItems($orderLines));
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));

        $order = Order::whereId($orderData['orderId'])->first();

        try {
            if (!isset($orderData['token'])) {
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

                if (!empty($orderData['coupon']) && $orderData['coupon']->seller_id === $sellerId) {
                    $total -= $orderData['coupon']->value;
                }

                Log::info('subtotal: ' . $subtotal . ' shipping: ' . $shipping . ' comission: ' . $commission . ' total: ' . $total);

                $charge = $stripeClient->charges->create([
                    'customer' => $customer['id'],
                    'currency' => config('shop.currency_code', 'GBP'),
                    'amount' => round(($total * 10 ** 2), 0),
                    'description' => 'Payment for order no ' . $order->id,
                    'capture' => false
                ]);



                /*$paymentIntent = $stripeClient->paymentIntents->create([
                    'customer' => $customer['id'],
                    'currency' => config('shop.currency_code', 'GBP'),
                    'amount' => round(($total * 10 ** 2), 0),
                    'description' => 'Payment for order no ' . $order->id,
                    'payment_method_types' => ['card'],
                    'capture_method' => 'manual',
                    // 'token' => $orderData['token'],
                ]);*/

                echo $charge['id'];

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
                    'external_payment_id' => $charge['id']
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

    public function createCustomer(array $data, int $sellerId): Customer
    {
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));

        $country = Country::where('id', $data['country_id'])->first();

        // Create a new Stripe customer.
        $customer = $stripeClient->customers->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => [
                'line1' => $data['address1'],
                'postal_code' => $data['zip'],
                'city' => $data['city'],
                'state' => $data['state'],
                'country' => $country->name,
            ],
            'shipping' => [
                'name' => $data['name'],
                'address' => [
                    'line1' => $data['address1'],
                    'postal_code' => $data['zip'],
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'country' => $country->name,
                ],
            ],
            //'source' => $orderData['token'],
        ]);

        Profile::where('user_id', $sellerId)->update(['external_customer_id' => $customer->id]);

        return $customer;
    }

    public function createSetupIntent()
    {
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));
        $setupIntent = $stripeClient->setupIntents->create(['payment_method_types' => ['card']]);

        return $setupIntent['client_secret'];
    }

    public function attachPaymentMethodToCustomer(string $paymentMethodId, int $sellerId): PaymentMethod
    {
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));
        return $stripeClient->paymentMethods->attach(
            $paymentMethodId,
            ['customer' => auth()->user()->external_customer_id]
        );
    }

    public function createAccount(array $data, int $sellerId): Account
    {
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));
        $profile = Profile::where('user_id', $sellerId)->first();
        $country = Country::where('id', $data['country_id'])->first();
        $account = $stripeClient->accounts->create([ //TODO Tos acceptance
            'country' => $country->code,
            'business_type' => 'individual',
            'email' => $data['email'],
            'controller' => [
                'fees' => ['payer' => 'application'],
                'losses' => ['payments' => 'application'],
                'stripe_dashboard' => ['type' => 'none'],
                'requirement_collection' => 'application'
            ],
            'capabilities' => [
                'card_payments' => ['requested' => true],
                'transfers' => ['requested' => true],
            ],
            'company' => [
                'address' => [
                    'city' => $data['city'],
                    'country' => $country->code,
                    'line1' => $data['address1'],
                    'line2' => $data['address2'],
                    'postal_code' => $data['zip'],
                    'state' => $data['state']
                ],
                'name' => $data['name'],
                'phone' => $data['phone'],
            ],
             'business_profile' => [
                'url' => $profile->website,
            ],
            'tos_acceptance' => [
                'date' => Carbon::now()->timestamp,
                'ip' => \Request::getClientIp()
            ]
        ]);

        $profile->update(['external_account_id' => $account['id'], 'balance_activated' => true]);
        return $account;
    }

    public function updateAccount(array $data, int $sellerId): Account
    {
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));
        $profile = Profile::where('user_id', $sellerId)->first();
        $country = Country::where('id', $profile->country_id)->first();

        $account = $stripeClient->accounts->update($profile->external_account_id, [ //TODO Tos acceptance
            'email' => $profile->email,
            'company' => [
                'address' => [
                    'city' => $data['city'],
                    'country' => $country->code,
                    'line1' => $data['address1'],
                    'line2' => $data['address2'],
                    'postal_code' => $data['zip'],
                    'state' => $data['state']
                ],
                'name' => $profile->name,
                'phone' => $profile->phone,

            ],
            'business_profile' => [
                'url' => $profile->website,
            ]
        ]);

        return $account;
    }

    public function createBankAccount(array $data, int $sellerId): BankAccount
    {
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));
        $profile = Profile::where('user_id', $sellerId)->first();
        $country = Country::where('id', $profile->country_id)->first();

        // 1. Generate a Btok
        $token = $stripeClient->tokens->create([
            'bank_account' => [
                'country' => $country->code, // Replace with the country
                'currency' => config('shop.currency_code'), // Replace with the currency
                'account_number' => $data['account_number'],
                'account_holder_name' => $data['account_name'],
                'routing_number' => $data['sort_code'],
                'account_holder_type' => 'individual', // Replace with the account holder type
            ]
        ]);

        $externalAccount = $stripeClient->accounts->createExternalAccount(
            $profile->external_account_id,
            ['external_account' => $token['id']]
        );

        SellerBankDetails::create(['payment_method_id' => $externalAccount['id'], 'seller_id' => $sellerId, 'type' => 'bank']);

        return $externalAccount;
    }

    public function updateBankAccount(int $sellerId, string $bankAccountId, array $data): BankAccount
    {
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));
        $profile = Profile::where('user_id', $sellerId)->first();

        return $stripeClient->accounts->updateExternalAccount(
            $profile->external_account_id,
            $bankAccountId,
            ['account_holder_name' => $data['account_name']]
        );
    }

    public function getBankAccount(int $sellerId, string $bankAccountId)
    {
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));
        $profile = Profile::where('user_id', $sellerId)->first();

        return $stripeClient->accounts->retrieveExternalAccount(
            $profile->external_account_id,
            $bankAccountId,
            []
        );
    }

    public function updateCard(string $paymentMethodId, array $data): PaymentMethod
    {
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));

        return $stripeClient->paymentMethods->update(
            $paymentMethodId,
            [
                'card' => [
                    'exp_month' => $data['expiry_month'],
                    'exp_year' => $data['expiry_year']
                ]
            ]
        );
    }

    public function updateCustomer(int $sellerId, array $data): Customer
    {
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));
        $country = Country::where('id', $data['country_id'])->first();
        $profile = Profile::where('user_id', $sellerId)->first();
        return $stripeClient->customers->update($profile->external_customer_id, [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => [
                'line1' => $data['address1'],
                'postal_code' => $data['zip'],
                'city' => $data['city'],
                'state' => $data['state'],
                'country' => $country->name,
            ],
            //'source' => $orderData['token'],
        ]);
    }

    public function getPaymentMethodsForCustomer(int $sellerId)
    {
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));
        return $stripeClient->customers->allPaymentMethods(
            auth()->user()->external_customer_id
        );
    }

    public function deleteCard(int $sellerId, string $paymentMethodId): PaymentMethod
    {
        $profile = Profile::where('user_id', $sellerId)->first();
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));
        return $stripeClient->paymentMethods->detach($paymentMethodId, []);

    }

    public function capturePayment(Transaction $transaction): Charge
    {
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));

        $charge = $stripeClient->charges->capture($transaction->external_payment_id);

        return $charge;
    }
}
