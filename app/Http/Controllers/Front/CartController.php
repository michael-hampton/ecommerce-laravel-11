<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyCouponCodeRequest;
use App\Models\ProductAttributeValue;
use App\Models\DeliveryMethod;
use App\Repositories\Interfaces\ICouponRepository;
use App\Services\Cart\Facade\Cart;
use App\Services\Interfaces\ICouponService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class CartController extends Controller
{
    public function __construct(
        private ICouponService    $couponService,
        private ICouponRepository $couponRepository
    )
    {

    }

    public function index()
    {
        $items = Cart::instance('cart')->content();
        $shippings = DeliveryMethod::all();
        $currency = config('shop.currency');
        $productAttributes = ProductAttributeValue::all();
        return view('front.cart', compact('items', 'currency', 'shippings', 'productAttributes'));
    }

    public function addToCart(Request $request)
    {
        Cart::instance('cart')->add(
            $request->id,
            $request->name,
            $request->quantity,
            $request->price
        )->associate('App\Models\Product');

        if ($request->ajax()) {
            return response()->json([
                'count' => Cart::instance('cart')->content()->count(),
                'view' => View::make('front.partials.cart-header', [
                    'items' => Cart::instance('cart')->content(),
                    'currency' => config('shop.currency'),
                ])->render()
            ]);
        }

        return redirect()->back();
    }

    public function removeFromCart(string $rowId)
    {
        Cart::instance('cart')->remove($rowId);

        if (\request()->ajax()) {
            return response()->json(['count' => Cart::instance('cart')->content()->count()]);
        }
        return redirect()->back();
    }

    public function emptyCart()
    {
        Cart::instance('cart')->destroy();

        if (\request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back();
    }

    public function updateShipping(string $rowId, Request $request)
    {
        $shippingId = $request->input('shipping_id');
        $shippingPrice = $request->input('shipping_price');

        Cart::instance('cart')->setShipping($rowId, $shippingId, $shippingPrice);
        return redirect()->back();
    }

    public function decreaseCartQuantity(string $rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId, $qty);

        if (\request()->ajax()) {
            return response()->json(['success' => true, 'quantity' => $qty, 'view' => View::make('front/partials/cart-sidebar', ['currency' => config('shop.currency')])->render()]);
        }

        return redirect()->back();
    }

    public function increaseCartQuantity(string $rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);

        if (\request()->ajax()) {
            return response()->json(['success' => true, 'quantity' => $qty, 'view' => View::make('front/partials/cart-sidebar', ['currency' => config('shop.currency')])->render()]);
        }

        return redirect()->back();
    }

    public function applyCoupon(ApplyCouponCodeRequest $request)
    {
        $couponCode = $request->get('coupon_code');

        if (!$this->couponService->applyCoupon($couponCode)) {

            if ($request->ajax()) {
                return response()->json(['error' => true]);
            }

            return redirect()->back()->withErrors(['error' => 'Coupon is invalid']);
        }

        if ($request->ajax()) {
            return view('front/partials/cart-sidebar', ['currency' => config('shop.currency')]);
        }

        return redirect()->back()->with('success', 'Coupon applied successfully');
    }

    public function removeCoupon()
    {
        Session::forget('coupon');
        Session::forget('discounts');

        if (\request()->ajax()) {
            return view('front/partials/cart-sidebar', ['currency' => config('shop.currency')]);
        }

        return back()->with('success', 'Coupon has been removed');
    }
}
