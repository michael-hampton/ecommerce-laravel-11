<?php

declare(strict_types=1);

namespace App\Actions\Seller;

use App\Models\SellerBankDetails;
use App\Services\PaymentProviders\PaymentProviderFactory;

class CreateCard
{
    public function handle(array $data): SellerBankDetails
    {
        (new PaymentProviderFactory())
            ->getClass()
            ->attachPaymentMethodToCustomer($data['payment_method_id'], auth('sanctum')->user()->id);

        return SellerBankDetails::create([
            'seller_id' => auth('sanctum')->user()->id,
            'payment_method_id' => $data['payment_method_id'],
            'type' => 'card',
        ]);


    }
}
