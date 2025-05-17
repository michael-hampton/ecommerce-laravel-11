<?php

declare(strict_types=1);

namespace App\Actions\Seller;

use App\Models\SellerBankDetails;
use App\Services\PaymentProviders\Stripe;
use Illuminate\Http\Request;

class CreateCard
{
    public function handle(Request $request)
    {
        SellerBankDetails::create([
            'seller_id' => auth('sanctum')->user()->id,
            'payment_method_id' => $request->string('payment_method_id'),

            // 'card_name' => $request->string('card_name'),
            // 'card_expiry_date' => $request->string('card_expiry_date'),
            // 'card_cvv' => $request->string('card_cvv'),
            // 'card_number' => $request->string('card_number'),
            'type' => 'card',
        ]);

        return (new Stripe())->attachPaymentMethodToCustomer($request->get('payment_method_id'), auth('sanctum')->user()->id);
    }
}
