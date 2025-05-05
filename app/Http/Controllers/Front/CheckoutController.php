<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Actions\Address\CreateAddress;
use App\Actions\Order\CreateOrder;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Country;
use App\Repositories\Interfaces\IAddressRepository;
use App\Repositories\Interfaces\IOrderRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class CheckoutController extends Controller
{
    public function __construct(
        private IAddressRepository $addressRepository,
        private IOrderRepository $orderRepository,
    ) {}

    public function index(Request $request)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        if (! empty($request->integer('shipping_id'))) {
            \App\Services\Cart\Facade\Cart::instance('cart')->setShippingId($request->integer('shipping_id'));
        }

        $countries = Country::orderBy('name', 'asc')->get();
        $addresses = $this->addressRepository->getAll(null, 'is_default', 'desc', ['customer_id' => auth()->user()->id]);

        return view('front.checkout', [
            'addresses' => $addresses,
            'countries' => $countries,
            'currency' => config('shop.currency'),
        ]);
    }

    public function placeOrder(CreateOrderRequest $request, CreateAddress $createAddress, CreateOrder $createOrder): RedirectResponse|View
    {
        $customerId = auth()->user()->id;
        $addressId = $request->integer('address');
        $addresses = $this->addressRepository->getAll(null, 'is_default', 'desc', ['customer_id' => auth()->user()->id]);
        $address = ! empty($addressId) ? $addresses->where('id', $addressId)->first() : $addresses->first();

        $adrressData = $request->except(['_token']);
        $adrressData['customer_id'] = $customerId;

        if ($request->has('address1')) {
            $address = $createAddress->handle($adrressData);
        }

        $adrressData['address_id'] = $address->id;

        if ($request->input('mode') !== 'card') {
            $order = $createOrder->handle($adrressData);

            Session::put('order_id', $order->id);

            return redirect()
                ->route('checkout.orderConfirmation', compact('order'))
                ->with('success', 'Order placed successfully');
        }

        return view('front.checkout-card', ['addressId' => $addressId, 'addresses' => $addresses, 'currency' => config('shop.currency')]);
    }

    public function placeCardOrder(CreateOrderRequest $request, CreateOrder $createOrder): RedirectResponse
    {
        $customerId = auth()->user()->id;
        $addressData = $request->except(['_token']);
        $addressData['customer_id'] = $customerId;
        $addressData['address_id'] = $request->integer('address');

        $order = $createOrder->handle($addressData);

        Session::put('order_id', $order->id);

        return redirect()
            ->route('checkout.orderConfirmation', compact('order'))
            ->with('success', 'Order placed successfully');
    }

    public function orderConfirmation(): View
    {
        $order = $this->orderRepository->getById(Session::get('order_id'));
        Session::forget('order_id');

        return view('front.order-confirmation', ['order' => $order]);
    }
}
