<?php

declare(strict_types=1);

namespace App\Http\Controllers\PaymentProviders;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IOrderRepository;
use App\Services\PaymentProviders\Paypal;
use Illuminate\Http\Request;

class PaypalController extends Controller
{
    public function __construct(private IOrderRepository $orderRepository) {}

    public function paymentCancel()
    {
        return redirect()
            ->route('paypal')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * @throws \Throwable
     */
    public function paymentSuccess(Request $request, int $orderId)
    {
        $order = $this->orderRepository->getById($orderId);
        $success = (new Paypal)->paymentSuccess($request);

        $order->transaction()->update(['payment_status' => 'pending']);

        if ($success) {
            return view('front.order-confirmation', ['order' => $order]);
        }

        return view('front.order-failed', ['order' => $order]);
    }
}
