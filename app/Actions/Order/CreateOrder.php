<?php

declare(strict_types=1);

namespace App\Actions\Order;

use App\Events\OrderCreated;
use App\Models\Coupon;
use App\Models\DeliveryMethod;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawalEnum;
use App\Models\WithdrawalTypeEnum;
use App\Notifications\ProductInWishlistSold;
use App\Repositories\Interfaces\IAddressRepository;
use App\Repositories\Interfaces\IOrderRepository;
use App\Services\Cart\Facade\Cart;
use App\Services\PaymentProviders\Paypal;
use App\Services\PaymentProviders\Stripe;
use App\Services\WithdrawalService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CreateOrder
{
    public function __construct(private readonly IOrderRepository $orderRepository, private readonly IAddressRepository $addressRepository) {}

    public function handle(array $data)
    {
        Cart::instance('cart')->setAddressId($data['address_id']);
        $this->setAmountForCheckout();

        $coupon = Session::has('coupon') ? Coupon::where('code', Session::get('coupon')['code'])->first() : null;

        DB::beginTransaction();

        try {
            $orderData = [
                'customer_id' => Auth::id(),
                'subtotal' => Session::get('checkout.subtotal'),
                'total' => Session::get('checkout.total'),
                'tax' => Session::get('checkout.tax'),
                'discount' => Session::get('checkout.discount'),
                'shipping' => Session::get('checkout.shipping'),
                'address_id' => $data['address_id'],
                'commission' => Session::get('checkout.commission'),
                'status' => 'pending'
            ];

            $cartItems = Cart::instance('cart')->content();

            $address = $this->addressRepository->getById($data['address_id']);
            $shipping = DeliveryMethod::where('country_id', $address->country_id)->get();

            $bulkPrice = config('shop.bulk_price');

            $order = $this->orderRepository->create($orderData);

            if (! $order) {
                DB::rollBack();
            }

            $groupBySeller = [];

            foreach ($cartItems as $item) {
                if (! isset($groupBySeller[$item->model->seller_id])) {
                    $groupBySeller[$item->model->seller_id] = 1;

                    continue;
                }

                $groupBySeller[$item->model->seller_id]++;
            }

            $test = [];

            foreach ($cartItems as $item) {
                $deliveryMethod = $item->getDeliveryMethod();
                $shippingPrice = empty($deliveryMethod) || $item->hasBulk ? $bulkPrice / $groupBySeller[$item->model->seller_id] : $deliveryMethod->price;

                $commission = $groupBySeller[$item->model->seller_id] > 1 ? Session::get('checkout.commission') / $groupBySeller[$item->model->seller_id] : Session::get('checkout.commission');

                $item->setShippingPrice(round($shippingPrice, 4));

                $discount = 0;

                if (! empty($coupon) && $coupon->seller_id === $item->model->seller_id) {
                    if ($groupBySeller[$item->model->seller_id] === 1) {
                        $discount = $coupon->value;
                    } elseif (Session::has('coupon') && ! empty(Session::get('coupon')['matched'])) {
                        $matched = Session::get('coupon')['matched'];
                        $discount = in_array($item->id, $matched) ? $coupon->value : 0;
                    } else {
                        $discount = $coupon->value / $groupBySeller[$item->model->seller_id];
                    }
                }

                $orderItemData = [
                    'commission' => $commission,
                    'product_id' => $item->id,
                    'quantity' => $item->qty,
                    'price' => $item->price,
                    'seller_id' => $item->model->seller_id,
                    'order_id' => $order->id,
                    'shipping_id' => empty($deliveryMethod) ? null : $deliveryMethod->id,
                    'shipping_price' => round($shippingPrice, 4),
                    'courier_id' => empty($deliveryMethod) ? null : $deliveryMethod->courier_id,
                ];

                if ($discount > 0) {
                    $orderItemData['coupon_id'] = $coupon->id;
                    $orderItemData['discount'] = $discount;
                }

                $test[$item->model->seller_id][] = [
                    'price' => $item->price,
                    'commission' => $commission,
                    'quantity' => $item->qty,
                    'shipping_price' => round($shippingPrice, 4), // TODO Need to allow for coupons
                    'discount' => $discount > 0 ? $discount : 0,
                ];

                $result = OrderItem::create($orderItemData);

                if (! $result) {
                    DB::rollBack();
                    break;
                }

                $item->model->decrement('quantity');

                $wishlistItems = collect(Cart::instance('wishlist')->getStoredItems())->filter(fn ($item): bool => $item->id == (string) $item->id);

                $wishlistItems->each(function ($item): void {
                    $user = User::where('email', $item->identifier)->firstOrFail();

                    $user->notify(new ProductInWishlistSold($item->model));
                });
            }

            if ($data['mode'] === 'seller_balance') {
                foreach ($test as $sellerId => $seller) {
                    $items = collect($seller);
                    $total = $items->map(fn (array $item): float => $item['discount'] > 0 ? (($item['price'] * $item['quantity']) + $item['shipping_price']) - $item['discount'] : ($item['price'] * $item['quantity']) + $item['shipping_price'])->first();

                    $transactionData = [
                        'order_id' => $order->id,
                        'seller_id' => $sellerId,
                        'status' => 'in-progress',
                        'payment_method' => 'seller_balance',
                        'customer_id' => Auth::id(),
                        'total' => $total,
                        'commission' => $items->sum('commission'),
                        'shipping' => $items->sum('shipping_price'),
                        'discount' => $items->sum('discount'),
                    ];

                    $result = Transaction::create($transactionData);

                    if (! $result) {
                        DB::rollBack();
                    }
                }

                (new WithdrawalService(
                    auth()->id(),
                    (float)Session::get('checkout.total'),
                    WithdrawalTypeEnum::OrderSpent,
                    WithdrawalEnum::Decrease,
                    $order->id
                ))->updateBalance();
            }

            Cart::deleteStoredCart('cart');
            Cart::instance('cart')->destroy();
            Session::forget('checkout');
            Session::forget('cart');
            Session::forget('coupon');

            event(new OrderCreated($order));

            if ($data['mode'] === 'paypal') {
                (new Paypal)->capture($cartItems, ['orderId' => $order->id, 'commission' => $orderData['commission'], 'coupon' => $coupon]);
            } elseif ($data['mode'] === 'card') {
                (new Stripe)->capture($cartItems, array_merge($data, ['orderId' => $order->id, 'commission' => $orderData['commission'], 'coupon' => $coupon]));
            }

            DB::commit();

            return $order;
        } catch (Exception $exception) {
            echo $exception->getMessage();
            exit;
        }
    }

    private function setAmountForCheckout(): void
    {
        if (Cart::instance('cart')->content()->isEmpty()) {
            Session::forget('checkout');

            return;
        }

        if (Session::has('coupon')) {
            Session::put('checkout', [
                'discount' => Session::get('discounts')['discount'],
                'subtotal' => Session::get('discounts')['subtotal'],
                'tax' => Session::get('discounts')['tax'],
                'shipping' => Session::get('discounts')['shipping'],
                'commission' => Session::get('discounts')['commission'],
                'total' => Session::get('discounts')['total'],
                'coupon' => Session::get('discounts'),
            ]);

            return;
        }

        Session::put('checkout', [
            'discount' => 0,
            'shipping' => Cart::instance('cart')->shipping(),
            'commission' => Cart::instance('cart')->commission(),
            'subtotal' => Cart::instance('cart')->subtotal(),
            'tax' => Cart::instance('cart')->tax(),
            'total' => Cart::instance('cart')->total(),
        ]);
    }
}
