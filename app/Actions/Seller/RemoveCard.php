<?php

declare(strict_types=1);

namespace App\Actions\Seller;

use App\Models\SellerBankDetails;
use App\Services\PaymentProviders\PaymentProviderFactory;

class RemoveCard
{
    public function handle(string $id): int|null
    {
        $card = SellerBankDetails::where('payment_method_id', $id);

         (new PaymentProviderFactory())
            ->getClass()
            ->deleteCard(auth('sanctum')->user()->id, $id);


        return $card->delete();
    }
}
