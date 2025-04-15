<?php

namespace App\Services;

use App\Models\Coupon;
use App\Repositories\Interfaces\ICouponRepository;
use App\Services\Cart\Facade\Cart;
use App\Services\Interfaces\ICouponService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CouponService implements ICouponService
{
    public function __construct(private ICouponRepository $repository)
    {

    }

    public function applyCoupon(string $couponCode): bool
    {
        $coupon = $this->repository->getAll(null, 'id', 'desc', ['code' => $couponCode, 'expiry_date' => Carbon::today(), 'cart_value' => Cart::instance('cart')->subtotal()])->first();

        if (!$coupon) {
            return false;
        }

        $hasSeller = false;

        $categoryValid = false;
        $brandValid = false;
        $cartItems = Cart::instance('cart')->content();
        $filtersRequired = !empty($coupon->categories) || !empty($coupon->brands);

        foreach ($cartItems as $cartItem) {
            if (!empty($coupon->categories) && in_array($cartItem->model->category_id, explode(',', $coupon->categories))) {
                $categoryValid = true;
            }

            if (!empty($coupon->brands) && in_array($cartItem->model->brand_id, explode(',', $coupon->brands))) {
                $brandValid = true;
            }

            if ($cartItem->model->seller_id === $coupon->seller_id) {
                $hasSeller = true;
            }
        }

        if($filtersRequired && (!$brandValid || !$categoryValid)) {
            return false;
        }

        if (!$hasSeller && !empty($coupon->seller_id)) {
            return false;
        }

        if ($coupon->expires_at <= Carbon::now()) {
            return false;
        }

        if($coupon->usages === 0) {
            return false;
        }

        DB::table('coupons')->decrement('usages');

        Session::put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'cart_value' => $coupon->cart_value
        ]);

        $this->calculateDiscount();

        return true;
    }

    private function calculateDiscount()
    {
        $discount = 0;
        if (Session::has('coupon')) {
            $coupon = Session::get('coupon');
            $discount = $coupon['value'];

            if ($coupon['type'] == 'fixed') {

            } else {
                $discount = (Cart::instance('cart')->subtotal() * $discount) / 100;
            }

            $subtotalAfterDiscount = Cart::instance('cart')->subtotal() - $discount;
            $tax = config('shop.tax');
            $total = $subtotalAfterDiscount;
            $taxAfterDiscount = 0;

            if ($tax > 0) {
                $taxAfterDiscount = ($subtotalAfterDiscount * config('shop.tax')) / 100;
                $total = $subtotalAfterDiscount + $taxAfterDiscount;
            }

            $shipping = Cart::instance('cart')->shipping();
            $commission = Cart::instance('cart')->commission();

            $total += $shipping + $commission;

            Session::put('discounts', [
                'discount' => number_format(floatval($discount), 2, '.', ''),
                'tax' => number_format(floatval($taxAfterDiscount), 2, '.', ''),
                'subtotal' => number_format(floatval($subtotalAfterDiscount), 2, '.', ''),
                'total' => number_format($total, 2, '.', ''),
                'shipping' => number_format($shipping, 2, '.', ''),
                'commission' => number_format($commission, 2, '.', ''),
            ]);
        }
    }

    public function createCoupon(array $data)
    {
        if (!empty($data['categories'])) {
            $data['categories'] = implode(',', $data['categories']);
        }

        if (!empty($data['brands'])) {
            $data['brands'] = implode(',', $data['brands']);
        }

        $data['seller_id'] = auth()->id();

        return $this->repository->create($data);
    }

    public function updateCoupon(array $data, int $id)
    {
        if (!empty($data['categories'])) {
            $data['categories'] = implode(',', $data['categories']);
        }

        if (!empty($data['brands'])) {
            $data['brands'] = implode(',', $data['brands']);
        }

        $data['seller_id'] = auth()->id();

        $this->repository->update($id, $data);
    }

    public function deleteCoupon(int $id)
    {
        $this->repository->delete($id);
    }
}
