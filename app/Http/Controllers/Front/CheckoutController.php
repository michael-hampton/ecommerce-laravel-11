<?php



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
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly IAddressRepository $addressRepository,
        private readonly IOrderRepository $orderRepository,
    ) {
    }

    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!empty($request->integer('shipping_id'))) {
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

    public function placeOrder(CreateOrderRequest $createOrderRequest, CreateAddress $createAddress, CreateOrder $createOrder): RedirectResponse|View
    {
        $customerId = auth()->user()->id;
        $addressId = $createOrderRequest->integer('address');
        $addresses = $this->addressRepository->getAll(null, 'is_default', 'desc', ['customer_id' => auth()->user()->id]);
        $address = empty($addressId) ? $addresses->first() : $addresses->where('id', $addressId)->first();

        $adrressData = $createOrderRequest->except(['_token']);
        $adrressData['customer_id'] = $customerId;

        if ($createOrderRequest->has('address1')) {
            $address = $createAddress->handle($adrressData);
        }

        $adrressData['address_id'] = $address->id;

        $order = $createOrder->handle($adrressData);

        Session::put('order_id', $order->id);

        return redirect()
            ->route('checkout.orderConfirmation', ['order' => $order])
            ->with('success', 'Order placed successfully');
    }

    public function orderConfirmation(): View
    {
        $order = $this->orderRepository->getById(Session::get('order_id'));
        Session::forget('order_id');

        return view('front.order-confirmation', ['order' => $order]);
    }
}
