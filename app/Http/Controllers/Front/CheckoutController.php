<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Country;
use App\Repositories\Interfaces\IAddressRepository;
use App\Repositories\Interfaces\IOrderRepository;
use App\Services\Interfaces\IAddressService;
use App\Services\Interfaces\IOrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function __construct(
        private IAddressRepository $addressRepository,
        private IAddressService    $addressService,
        private IOrderService      $orderService,
        private IOrderRepository   $orderRepository,
    )
    {

    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $countries = Country::orderBy('name', 'asc')->get();
        $addresses = $this->addressRepository->getAll(null, 'is_default', 'desc', ['customer_id' => auth()->user()->id]);
        return view('front.checkout', [
            'addresses' => $addresses,
            'countries' => $countries,
            'currency' => config('shop.currency')
        ]);
    }

    public function placeOrder(CreateOrderRequest $request)
    {
        $customerId = auth()->user()->id;
        $addressId = $request->integer('address');
        $addresses = $this->addressRepository->getAll(null, 'is_default', 'desc', ['customer_id' => auth()->user()->id]);
        $address = !empty($addressId) ? $addresses->where('id', $addressId)->first() : $addresses->first();

        $adrressData = $request->except(['_token']);
        $adrressData['customer_id'] = $customerId;

        if ($request->has('address1')) {
            $address = $this->addressService->createAddress($adrressData);
        }

        $adrressData['address_id'] = $address->id;

        if ($request->input('mode') !== 'card') {
            $order = $this->orderService->createOrder($adrressData);

            Session::put('order_id', $order->id);

            return redirect()
                ->route('checkout.orderConfirmation', compact('order'))
                ->with('success', 'Order placed successfully')
            ;
        }

        return view('front.checkout-card', ['addressId' => $addressId, 'addresses' => $addresses, 'currency' => config('shop.currency')]);
    }

    public function placeCardOrder(CreateOrderRequest $request)
    {
        $customerId = auth()->user()->id;
        $addressData = $request->except(['_token']);
        $addressData['customer_id'] = $customerId;
        $addressData['address_id'] = $request->integer('address');;

        $order = $this->orderService->createOrder($addressData);

        Session::put('order_id', $order->id);

        return redirect()
            ->route('checkout.orderConfirmation', compact('order'))
            ->with('success', 'Order placed successfully')
        ;
    }

    public function orderConfirmation()
    {
        $order = $this->orderRepository->getById(Session::get('order_id'));
        Session::forget('order_id');

        return view('front.order-confirmation', ['order' => $order]);
    }
}
