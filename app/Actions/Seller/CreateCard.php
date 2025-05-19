<?php

declare(strict_types=1);

namespace App\Actions\Seller;

use App\Models\SellerBankDetails;
use App\Services\PaymentProviders\PaymentProviderFactory;
use App\Services\PaymentProviders\Stripe;
use Illuminate\Http\Request;

class CreateCard
{
    public function handle(Request $request)
    {
        SellerBankDetails::create([
            'seller_id' => auth('sanctum')->user()->id,
            'payment_method_id' => $request->string('payment_method_id'),
            'type' => 'card',
        ]);

        return  (new PaymentProviderFactory())
            ->getClass()
            ->attachPaymentMethodToCustomer($request->get('payment_method_id'), auth('sanctum')->user()->id);
    }
}
