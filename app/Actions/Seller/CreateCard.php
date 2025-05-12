<?php

declare(strict_types=1);

namespace App\Actions\Seller;

use App\Models\SellerBankDetails;
use Illuminate\Http\Request;

class CreateCard
{
    public function handle(Request $request)
    {
        $test = [
            'seller_id' => auth('sanctum')->user()->id,
            'card_name' => $request->string('card_name'),
            'card_expiry_date' => $request->string('card_expiry_date'),
            'card_cvv' => $request->string('card_cvv'),
            'card_number' => $request->string('card_number'),
            'type' => 'card',
        ];
        
        return SellerBankDetails::create([
            'seller_id' => auth('sanctum')->user()->id,
            'card_name' => $request->string('card_name'),
            'card_expiry_date' => $request->string('card_expiry_date'),
            'card_cvv' => $request->string('card_cvv'),
            'card_number' => $request->string('card_number'),
            'type' => 'card',
        ]);
    }
}
