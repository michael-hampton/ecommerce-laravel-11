<?php

declare(strict_types=1);

namespace App\Actions\Coupon;

use App\Repositories\Interfaces\ICouponRepository;
use App\Services\Cart\Facade\Cart;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ApplyCoupon
{
    public function __construct(private readonly ICouponRepository $couponRepository) {}

    public function handle(string $couponCode): bool
    {
        $coupon = $this->couponRepository->getAll(null, 'id', 'desc', ['code' => $couponCode, 'expiry_date' => Carbon::today(), 'cart_value' => Cart::instance('cart')->subtotal()])->first();

        $hasSeller = false;

        $categoryValid = false;
        $brandValid = false;
        $cartItems = Cart::instance('cart')->content();
        $filtersRequired = ! empty($coupon->categories) || ! empty($coupon->brands);

        $matched = [];

        foreach ($cartItems as $cartItem) {
            if (! empty($coupon->categories) && in_array($cartItem->model->category_id, explode(',', (string) $coupon->categories))) {
                $categoryValid = true;
            }

            if (! empty($coupon->brands) && in_array($cartItem->model->brand_id, explode(',', (string) $coupon->brands))) {
                $brandValid = true;
            }

            if ($cartItem->model->seller_id === $coupon->seller_id) {
                $hasSeller = true;
            }

            if ($filtersRequired && ($categoryValid || $brandValid)) {
                $matched[] = $cartItem->model->id;
            }
        }

        if ($filtersRequired && (! $brandValid || ! $categoryValid)) {
            return false;
        }

        if (! $hasSeller && ! empty($coupon->seller_id)) {
            return false;
        }

        if ($coupon->expires_at <= Carbon::now()) {
            return false;
        }

        if ($coupon->usages === 0) {
            return false;
        }

        DB::table('coupons')->decrement('usages');

        Session::put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'cart_value' => $coupon->cart_value,
            'matched' => $matched,
        ]);

        $this->calculateDiscount();

        return true;
    }

    private function calculateDiscount(): void
    {
        $discount = 0;
        if (Session::has('coupon')) {
            $coupon = Session::get('coupon');
            $discount = $coupon['value'];

            if ($coupon['type'] != 'fixed') {
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
}
