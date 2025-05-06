<?php

namespace App\Actions\Seller;

use App\Models\SellerBillingInformation;
use Illuminate\Http\Request;

class SaveBillingInformation
{
    public function handle(Request $request) {
       return SellerBillingInformation::updateOrCreate(
            ['seller_id' => auth('sanctum')->user()->id],
            array_merge($request->all(), ['seller_id' => auth('sanctum')->id()])
        );
    }
}
