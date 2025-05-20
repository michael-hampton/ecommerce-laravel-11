<?php

declare(strict_types=1);

namespace App\Services\PaymentProviders;

use App\Models\Country;
use App\Models\Order;
use App\Models\Profile;
use App\Models\SellerBankDetails;
use App\Models\Transaction;
use App\Models\User;
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
use Stripe\PaymentIntent;
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
            if (!isset($orderData['token']) && empty($orderData['existing_card'])) {
                dd('no');

                return false;
            }

            if (empty($orderData['existing_card'])) {

                if (Auth::check() && auth()->user()->external_customer_id) {
                    $customerId = auth()->user()->external_customer_id;
                } else {
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

                    $customerId = $customer['id'];
                }

            } else {
                $customerId = auth()->user()->external_customer_id;
            }

            foreach ($items as $sellerId => $item) {

                $products = collect($item);

                $subtotal = $products->sum('price');
                $shipping = round($products->sum('shipping'), 2);
                $commission = $items->count() > 1 ? $orderData['commission'] / $items->count() : $orderData['commission'];
                $total = $subtotal + $shipping + $commission;

                if (!empty($orderData['coupon']) && $orderData['coupon']->seller_id === $sellerId) {
                    $total -= $orderData['coupon']->value;
                }

                $paymentIntentData = [
                    'amount' => 2000,
                    'currency' => 'usd',
                    'capture_method' => 'manual',
                    'customer' => $customerId,
                    'setup_future_usage' => 'off_session',
                    'confirm' => true,
                    'automatic_payment_methods' => [
                        'enabled' => true,
                        'allow_redirects' => 'never'
                    ],
                ];

                if (!empty($orderData['existing_card'])) {
                    $paymentIntentData['payment_method'] = $orderData['existing_card'];
                }

                $paymentIntent = $stripeClient->paymentIntents->create($paymentIntentData);

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
                    'external_payment_id' => $paymentIntent['id']
                ];

                Transaction::create($transactionData);

                if ($paymentIntent['status'] == 'succeeded' || $paymentIntent['status'] === 'requires_confirmation') {
                    $order->transaction()->update(['payment_status' => 'pending']);
                }
            }

        } catch (Exception $exception) {
            dd($exception->getMessage());

            return false;
        }

        return false;
    }

    public function getPaymentMethod(string $paymentMethodId)
    {
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));
        return $stripeClient->paymentMethods->retrieve(
            $paymentMethodId,
            []
        );
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

        User::where('id', $sellerId)->update(['external_customer_id' => $customer->id]);

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

        if (empty($profile->user->external_customer_id)) {
            $this->createCustomer($data, $sellerId);
        }


        $country = Country::where('id', $data['country_id'])->first();
        $account = $stripeClient->accounts->create([
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

        if (empty($profile->user->external_customer_id)) {
            $this->createCustomer($data, $sellerId);
        }

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

    public function getBankAccount(int $sellerId, string $bankAccountId): array
    {
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));
        $profile = Profile::where('user_id', $sellerId)->first();

        $bankAccount = $stripeClient->accounts->retrieveExternalAccount(
            $profile->external_account_id,
            $bankAccountId,
            []
        );

        return [
            'account_name' => $bankAccount['account_holder_name'],
            'account_number' => $bankAccount['last4'],
            'sort_code' => $bankAccount['routing_number'],
            'bank_name' => $bankAccount['bank_name'],
        ];
    }

    public function updateCard(string $paymentMethodId, array $data): array
    {
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));

        $card = $stripeClient->paymentMethods->update(
            $paymentMethodId,
            [
                'card' => [
                    'exp_month' => $data['expiry_month'],
                    'exp_year' => $data['expiry_year']
                ]
            ]
        );

        return [
            'id' => $card['id'],
            'card_type' => $card['card']['brand'],
            'card_expiry_date' => $card['card']['exp_month'] . '/' . $card['card']['exp_year'],
            'formatted_card_number' => $card['card']['last4'],
            'card_number' => $card['card']['last4'],
        ];
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

    public function getPaymentMethodsForCustomer(int $sellerId): Collection
    {
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));
        $cards = $stripeClient->customers->allPaymentMethods(
            auth()->user()->external_customer_id
        );

        return collect($cards['data'])->map(function ($item) {
            return [
                'id' => $item['id'],
                'card_type' => $item['card']['brand'],
                'card_expiry_date' => $item['card']['exp_month'] . '/' . $item['card']['exp_year'],
                'formatted_card_number' => $item['card']['last4'],
                'card_number' => $item['card']['last4'],
            ];
        });
    }

    public function deleteCard(int $sellerId, string $paymentMethodId): PaymentMethod
    {
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));
        return $stripeClient->paymentMethods->detach($paymentMethodId, []);

    }

    public function capturePayment(Transaction $transaction): PaymentIntent
    {
        $stripeClient = new StripeClient(env('STRIPE_SECRET'));

        $charge = $stripeClient->paymentIntents->capture($transaction->external_payment_id);

        return $charge;
    }
}
