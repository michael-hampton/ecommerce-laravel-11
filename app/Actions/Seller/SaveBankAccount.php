<?php

declare(strict_types=1);

namespace App\Actions\Seller;

use App\Models\SellerBankDetails;
use Illuminate\Http\Request;

class SaveBankAccount
{
    public function handle(Request $request): SellerBankDetails
    {
        return SellerBankDetails::updateOrCreate(
            ['seller_id' => auth('sanctum')->user()->id, 'type' => 'bank'],
            array_merge($request->all(), ['seller_id' => auth('sanctum')->user()->id, 'type' => 'bank'])
        );

    }
}
