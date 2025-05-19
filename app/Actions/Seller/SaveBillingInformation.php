<?php

declare(strict_types=1);

namespace App\Actions\Seller;

use App\Models\SellerBillingInformation;
use App\Services\PaymentProviders\PaymentProviderFactory;
use Illuminate\Http\Request;

class SaveBillingInformation
{
    public function handle(Request $request): SellerBillingInformation
    {
        $currentData = SellerBillingInformation::where("id", auth('sanctum')->user()->id)->first();

        if (!empty($currentData)) {
            (new PaymentProviderFactory())
                ->getClass()
                ->updateAccount($request->all(), auth('sanctum')->id());
        }

        return SellerBillingInformation::updateOrCreate(
            ['seller_id' => auth('sanctum')->user()->id],
            array_merge($request->all(), ['seller_id' => auth('sanctum')->id()])
        );
    }
}
