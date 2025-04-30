<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\DeliveryMethod;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderLog;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WithdrawalEnum;
use App\Models\WithdrawalTypeEnum;
use App\Repositories\Interfaces\IAddressRepository;
use App\Repositories\Interfaces\IOrderRepository;
use App\Services\Cart\Facade\Cart;
use App\Services\Interfaces\IOrderService;
use App\Services\PaymentProviders\Paypal;
use App\Services\PaymentProviders\Stripe;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use function auth;

class OrderService implements IOrderService
{
    public function __construct(private IOrderRepository $repository, private IAddressRepository $addressRepository)
    {

    }

    public function createOrder(array $data)
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
                'commission' => Session::get('checkout.commission')
            ];

            $cartItems = Cart::instance('cart')->content();
            $address = $this->addressRepository->getById($data['address_id']);
            $shipping = DeliveryMethod::where('country_id', $address->country_id)->get();
            $bulkPrice = config('shop.bulk_price');

            $order = $this->repository->create($orderData);

            if (!$order) {
                DB::rollBack();
            }

            $groupBySeller = [];

            foreach ($cartItems as $item) {
                if (!isset($groupBySeller[$item->model->seller_id])) {
                    $groupBySeller[$item->model->seller_id] = 1;
                    continue;
                }
                $groupBySeller[$item->model->seller_id]++;
            }

            $test = [];

            foreach ($cartItems as $item) {
                $deliveryMethod = $item->getDeliveryMethod();
                $shippingPrice = empty($deliveryMethod) ? $bulkPrice / $groupBySeller[$item->model->seller_id] : $deliveryMethod->price;

                $commission = count($groupBySeller) > 1 ? Session::get('checkout.commission') / count($groupBySeller) : Session::get('checkout.commission');

                $item->setShippingPrice(round($shippingPrice, 4));

                $discount = 0;

                if(!empty($coupon) && $coupon->seller_id === $item->model->seller_id) {
                    if( $groupBySeller[$item->model->seller_id] === 1) {
                        $discount = $coupon->value;
                    } elseif(Session::has('coupon')) {
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
                    'shipping_id' => !empty($deliveryMethod) ? $deliveryMethod->id : null,
                    'shipping_price' => round($shippingPrice, 4),
                    'courier_id' => !empty($deliveryMethod) ? $deliveryMethod->courier_id : null,
                ];

                if ($discount > 0) {
                    $orderItemData['coupon_id'] = $coupon->id;
                    $orderItemData['discount'] = $discount;
                }

                $test[$item->model->seller_id][] = [
                    'price' => $item->price,
                    'commission' => $commission,
                    'quantity' => $item->qty,
                    'shipping_price' => round($shippingPrice, 4), //TODO Need to allow for coupons
                    'discount' => $discount > 0 ? $discount : 0
                ];

                $result = OrderItem::create($orderItemData);

                if (!$result) {
                    DB::rollBack();
                    break;
                }
            }

            if ($data['mode'] === 'seller_balance') {
                foreach ($test as $sellerId => $seller) {
                    $items = collect($seller);
                    $total = $items->map(function ($item) {
                        return $item['discount'] > 0 ? (($item['price'] * $item['quantity']) + $item['shipping_price']) - $item['discount'] : ($item['price'] * $item['quantity']) + $item['shipping_price'];
                    })->first();

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

                    if (!$result) {
                        DB::rollBack();
                    }
                }

                (new WithdrawalService(
                    auth()->id(),
                    Session::get('checkout.total'),
                    WithdrawalTypeEnum::OrderSpent,
                    WithdrawalEnum::Decrease,
                    8
                ))->updateBalance();
            }

            DB::table('products')->decrement('quantity');
            Cart::deleteStoredCart('cart');
            Cart::instance('cart')->destroy();
            Session::forget('checkout');
            Session::forget('cart');
            Session::forget('coupon');

            $email = $order->customer->email;
            $messageData = [
                'email' => $email,
                'name' => $order->customer->name,
                'order_id' => $order->id,
                'order' => $order,
                'orderItems' => $order->orderItems,
                'currency' => config('shop.currency'),
            ];

            Mail::send('emails.order', $messageData, function ($message) use ($email, $order) {
                $message->to($email)->subject('Order #' . $order->id . ' was successfully created!');
            });

            if ($data['mode'] === 'paypal') {
                (new Paypal())->capture($cartItems, ['orderId' => $order->id, 'commission' => $orderData['commission'], 'coupon' => $coupon]);
            } elseif ($data['mode'] === 'card') {
                (new Stripe())->capture($cartItems, array_merge($data, ['orderId' => $order->id, 'commission' => $orderData['commission'], 'coupon' => $coupon]));
            }

            DB::commit();

            return $order;
        } catch (Exception $ex) {
            print_r($ex->getMessage());
            die;
            DB::rollBack();
        }
    }

    private function setAmountForCheckout()
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
                'coupon' => Session::get('discounts')
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

    public function updateOrder(array $data, int $id)
    {
        $orderData = ['status' => $data['status']];

        if ($data['status'] === 'delivered') {
            $orderData['delivered_date'] = now();
        }

        if ($data['status'] === 'cancelled') {
            $orderData['cancelled_date'] = now();
        }

        if (!empty($data['tracking_number'])) {
            $orderData['tracking_number'] = $data['tracking_number'];
        }

        if ($data['courier_id']) {
            $orderData['courier_id'] = $data['courier_id'];
        }

        $this->repository->update($id, $orderData);

        if ($data['status'] === 'delivered') {
            $order = $this->repository->getById($id);
            $transaction = $order->transaction->where('seller_id', auth()->id())->first();
            $transaction->payment_status = $data['status'] === 'delivered' ? 'approved' : 'refunded';
            $transaction->save();
        }

        $order = $this->repository->getById($id);
        $email = $order->customer->email;
        $messageData = [
            'email' => $email,
            'name' => $order->customer->name,
            'order_id' => $order->id,
            'order' => $order,
            'orderItems' => $order->orderItems,
            'currency' => config('shop.currency'),
        ];

        Mail::send('emails.order_status', $messageData, function ($message) use ($email, $order) {
            $message->to($email)->subject('Order #' . $order->id);
        });

        OrderLog::create([
            'order_id' => $id,
            'courier_name' => $data['courier_id'],
            'tracking_number' => $data['tracking_number'],
            'status_to' => $data['status'],
        ]);
    }

    public function updateOrderLine(array $data, int $id)
    {
        $orderData = ['status' => $data['status']];

        if ($data['status'] === 'delivered') {
            $orderData['delivered_date'] = now();
        }

        if ($data['status'] === 'cancelled') {
            $orderData['cancelled_date'] = now();
        }

        if (!empty($data['tracking_number'])) {
            $orderData['tracking_number'] = $data['tracking_number'];
        }

        if ($data['courier_id']) {
            $orderData['courier_id'] = $data['courier_id'];
        }

        $orderItem = OrderItem::with('order')->whereId($id)->first();
        $order = $orderItem->order;

        $orderItem->update($orderData);

        if ($data['status'] === 'delivered') {
            $transactions = $order->transaction->where('seller_id', auth('sanctum')->user()->id);
            //$transaction->payment_status = $data['status'] === 'delivered' ? 'approved' : 'refunded';
            Transaction::whereIn('id', $transactions->pluck('id'))->update(['payment_status' => $data['status'] === 'delivered' ? 'approved' : 'refunded']);
        }

        $email = $order->customer->email;
        $messageData = [
            'email' => $email,
            'name' => $order->customer->name,
            'order_id' => $order->id,
            'order' => $order,
            'orderItems' => $order->orderItems->where('id', $id)->all(),
            'currency' => config('shop.currency'),
        ];

        Mail::send('emails.order_status', $messageData, function ($message) use ($email, $order) {
            $message->to($email)->subject('Order #' . $order->id);
        });

        OrderLog::create([
            'order_item_id' => $id,
            'courier_name' => $data['courier_id'],
            'tracking_number' => $data['tracking_number'],
            'status_to' => $data['status'],
        ]);

        return $orderItem;
    }

    public function approveOrder(int $orderId)
    {
        $order = Order::whereId($orderId)->firstOrFail();
        $transactionsBySeller = $order->transaction->groupBy('seller_id');

        foreach ($transactionsBySeller as $sellerId => $transactions) {
            (new WithdrawalService(
                $sellerId,
                $transactions->sum('total'),
                WithdrawalTypeEnum::OrderReceived,
                WithdrawalEnum::Increase,
                $transactions->first()->id
            ))->updateBalance();

            $orderItems = OrderItem::where('seller_id', $sellerId)->where('order_id', $orderId);

            $orderItems->update(['approved_date' => now()]);

            Transaction::where('seller_id', $sellerId)
                ->where('order_id', $orderId)
                ->update(['payment_status' => 'approved'])
            ;

            $this->sendOrderApprovedNotification($order, $orderItems, $sellerId);
        }

        $order->update(['status' => 'complete']);

        return true;
    }

    public function approveOrderItem(int $orderItemId)
    {
        $orderItem = OrderItem::whereId($orderItemId)->firstOrFail();
        $order = $orderItem->order;
        $transaction = $order->transaction->where('seller_id', $orderItem->seller_id)->first();

        if (empty($transaction)) {
            return false;
        }

        DB::beginTransaction();

        try {
            $sellerId = $orderItem->seller_id;

            (new WithdrawalService(
                $sellerId,
                $transaction->total,
                WithdrawalTypeEnum::OrderReceived,
                WithdrawalEnum::Increase,
                $transaction->id
            ))->updateBalance();

            $orderItem->update(['approved_date' => now()]);

            Transaction::where('seller_id', $sellerId)
                ->where('order_id', $order->id)
                ->update(['payment_status' => 'approved'])
            ;


            $allApproved = true;

            foreach ($order->orderItems as $item) {
                if (empty($item->approved_date)) {
                    $allApproved = false;
                    break;
                }
            }

            if ($allApproved) {
                $order->update(['status' => 'complete']);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
        }

        $this->sendOrderApprovedNotification($order, $orderItem, $sellerId);

        return true;
    }

    private function sendOrderApprovedNotification(Order $order, $orderItems, int $sellerId)
    {
        $user = User::whereId($sellerId)->firstOrFail();
        $email = $user->email;
        $messageData = [
            'email' => $email,
            'name' => $order->customer->name,
            'order_id' => $order->id,
            'order' => $order,
            'orderItems' => $orderItems,
            'currency' => config('shop.currency'),
        ];

        Mail::send('emails.order-approved', $messageData, function ($message) use ($email, $order) {
            $message->to($email)->subject('Order #' . $order->id);
        });
    }

    public function deleteOrder(array $data)
    {

    }
}
