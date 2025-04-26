<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSellerBankDetails;
use App\Http\Requests\UpdateSellerCardDetails;
use App\Models\SellerBankDetails;

class SellerAccountController extends Controller
{
    public function saveBankDetails(UpdateSellerBankDetails $request)
    {
        $result = SellerBankDetails::updateOrCreate(
            ['seller_id' => auth('sanctum')->user()->id, 'type' => 'bank'],
            array_merge($request->all(), ['seller_id' => auth('sanctum')->user()->id, 'type' => 'bank'])
        );

        return response()->json($result);
    }

    public function saveCardDetails(UpdateSellerCardDetails $request)
    {
        $result = SellerBankDetails::updateOrCreate(
            ['seller_id' => auth('sanctum')->user()->id, 'type' => 'card'],
            array_merge($request->all(), ['seller_id' => auth('sanctum')->user()->id, 'type' => 'card'])
        );

        return response()->json($result);
    }

    public function getSellerBankAccountDetails() {
        return response()->json(
            SellerBankDetails::where('seller_id', auth('sanctum')->user()->id)
                ->where('type', 'bank')
                ->first());
    }

    public function getSellerCardAccountDetails() {
        return response()->json(
            SellerBankDetails::where('seller_id', auth('sanctum')->user()->id)
                ->where('type', 'card')
                ->first());
    }
}
