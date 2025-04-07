<?php

namespace App\Services;

use App\Models\OrderItem;
use App\Models\OrderLog;
use App\Models\Shipping;
use App\Repositories\Interfaces\IOrderRepository;
use App\Services\Cart\Facade\Cart;
use App\Services\Interfaces\IOrderService;
use App\Services\PaymentProviders\Paypal;
use App\Services\PaymentProviders\Stripe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderService implements IOrderService
{
    public function __construct(private IOrderRepository $repository)
    {

    }

    public function createOrder(array $data)
    {
        $this->setAmountForCheckout();

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

        $shipping = Shipping::all();
        $bulkPrice = $shipping->where('name', 'Bulk')->first()->price;

        $order = $this->repository->create($orderData);

        $groupBySeller = [];

        foreach ($cartItems as $item) {
            if (!isset($groupBySeller[$item->model->seller_id])) {
                $groupBySeller[$item->model->seller_id] = 1;
                continue;
            }
            $groupBySeller[$item->model->seller_id]++;
        }

        foreach ($cartItems as $key => $item) {

            $isBulk = isset($groupBySeller[$item->model->seller_id]) && $groupBySeller[$item->model->seller_id] > 1;

            $shippingPrice = $isBulk ? $bulkPrice / $groupBySeller[$item->model->seller_id] : $item->shipping();

            $item->setShippingPrice(round($shippingPrice, 4));

            $orderItemData = [
                'product_id' => $item->id,
                'quantity' => $item->qty,
                'price' => $item->price,
                'seller_id' => $item->model->seller_id,
                'order_id' => $order->id,
                'shipping_id' => $item->getShippingId($isBulk)->id,
                'shipping_price' => round($shippingPrice, 4),
            ];

            OrderItem::create($orderItemData);
        }

        DB::table('products')->decrement('quantity');
        Cart::deleteStoredCart('cart');
        Cart::instance('cart')->destroy();
        Session::forget('checkout');
        Session::forget('cart');
        Session::forget('coupon');

        if ($data['mode'] === 'paypal') {
            (new Paypal())->capture($cartItems, ['orderId' => $order->id, 'commission' => $orderData['commission']]);
        } elseif ($data['mode'] === 'card') {
            (new Stripe())->capture($cartItems, array_merge($data, ['orderId' => $order->id, 'commission' => $orderData['commission']]));
        }

        return $order;
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

        if ($data['courier_name']) {
            $orderData['courier_name'] = $data['courier_name'];
        }

        $this->repository->update($id, $orderData);

        if ($data['status'] === 'delivered') {
            $order = $this->repository->getById($id);
            $transaction = $order->transaction->where('seller_id', \auth()->id())->first();
            $transaction->payment_status = $data['status'] === 'delivered' ? 'approved' : 'refunded';
            $transaction->save();
        }

        OrderLog::create([
           'order_id' => $id,
            'courier_name' => $data['courier_name'],
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

        if ($data['courier_name']) {
            $orderData['courier_name'] = $data['courier_name'];
        }

        OrderItem::whereId($id)->update($orderData);

        if ($data['status'] === 'delivered') {
            $order = $this->repository->getById($id);
            $transaction = $order->transaction->where('seller_id', \auth()->id())->first();
            $transaction->payment_status = $data['status'] === 'delivered' ? 'approved' : 'refunded';
            $transaction->save();
        }

        OrderLog::create([
            'order_item_id' => $id,
            'courier_name' => $data['courier_name'],
            'tracking_number' => $data['tracking_number'],
            'status_to' => $data['status'],
        ]);
    }

    public function deleteOrder(array $data)
    {

    }

    private function truncateNumber($number, $precision = 2)
    {
        // Zero causes issues, and no need to truncate
        if (0 == (int)$number) {
            return $number;
        }
        // Are we negative?
        $negative = $number / abs($number);
        // Cast the number to a positive to solve rounding
        $number = abs($number);
        // Calculate precision number for dividing / multiplying
        $precision = pow(10, $precision);
        // Run the math, re-applying the negative value to ensure returns correctly negative / positive
        return floor($number * $precision) / $precision * $negative;
    }
}
