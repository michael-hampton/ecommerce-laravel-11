<?php

declare(strict_types=1);

namespace App\Actions\Seller;

use App\Models\SellerBillingInformation;
use App\Services\PaymentProviders\PaymentProviderFactory;

class SaveBillingInformation
{
    public function handle(array $data): SellerBillingInformation
    {
        $currentData = SellerBillingInformation::where("id", auth('sanctum')->user()->id)->first();

        if (!empty($currentData)) {
            (new PaymentProviderFactory())
                ->getClass()
                ->updateAccount($data, auth('sanctum')->id());
        }

        return SellerBillingInformation::updateOrCreate(
            ['seller_id' => auth('sanctum')->user()->id],
            array_merge($data, ['seller_id' => auth('sanctum')->id()])
        );
    }
}
