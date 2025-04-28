<?php

namespace App\Services;

use App\Models\DeliveryMethod;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderLog;
use App\Models\Transaction;
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
            $bulkPrice = $shipping->where('name', 'Bulk')->first()->price;

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

            foreach ($cartItems as $key => $item) {
                $deliveryMethod = $item->getDeliveryMethod();
                $shippingPrice = empty($deliveryMethod) ? $bulkPrice / $groupBySeller[$item->model->seller_id] : $deliveryMethod->price;
                $isBulk = isset($groupBySeller[$item->model->seller_id]) && $groupBySeller[$item->model->seller_id] > 1;

                $commission = $isBulk ? Session::get('checkout.commission') / $groupBySeller[$item->model->seller_id] : Session::get('checkout.commission');

                $item->setShippingPrice(round($shippingPrice, 4));

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

                $result = OrderItem::create($orderItemData);

                if (!$result) {
                    DB::rollBack();
                    break;
                }

                if ($data['mode'] === 'seller_balance') {
                    $itemTotal = ($item->price * $item->qty) + $shippingPrice;
                    if (!empty(Session::has('coupon'))) {
                        $itemTotal -= Session::get('coupon')['value'];
                    }

                    $transactionData = [
                        'order_id' => $order->id,
                        'seller_id' => $item->model->seller_id,
                        'status' => 'in-progress',
                        'payment_method' => 'seller_balance',
                        'customer_id' => Auth::id(),
                        'total' => $itemTotal,
                        'commission' => $commission,
                        'shipping' => $shippingPrice,
                        'discount' => Session::has('coupon') ? Session::get('coupon')['value'] : 0,
                    ];

                    $result = Transaction::create($transactionData);

                    if (!$result) {
                        DB::rollBack();
                    }
                }
            }

            if ($data['mode'] === 'seller_balance') {
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
                (new Paypal())->capture($cartItems, ['orderId' => $order->id, 'commission' => $orderData['commission']]);
            } elseif ($data['mode'] === 'card') {
                (new Stripe())->capture($cartItems, array_merge($data, ['orderId' => $order->id, 'commission' => $orderData['commission']]));
            }

            DB::commit();

            return $order;
        } catch (Exception) {
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

            OrderItem::where('seller_id', $sellerId)
                ->where('order_id', $orderId)
                ->update(['approved_date' => now()])
            ;

            Transaction::where('seller_id', $sellerId)
                ->where('order_id', $orderId)
                ->update(['payment_status' => 'approved'])
            ;
        }

        $order->update(['status' => 'complete']);
    }

    public function deleteOrder(array $data)
    {

    }
}
