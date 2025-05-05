<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Seller;

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

        if (! $result) {
            return $this->error('Unable to save bank details');
        }

        return $this->success($result, 'bank details updated');
    }

    public function saveCardDetails(UpdateSellerCardDetails $request)
    {
        $result = SellerBankDetails::updateOrCreate(
            ['seller_id' => auth('sanctum')->user()->id, 'type' => 'card'],
            array_merge($request->all(), ['seller_id' => auth('sanctum')->user()->id, 'type' => 'card'])
        );

        if (! $result) {
            return $this->error('Unable to save card');
        }

        return $this->success($result, 'card updated');
    }

    public function getSellerBankAccountDetails()
    {
        return response()->json(
            SellerBankDetails::where('seller_id', auth('sanctum')->user()->id)
                ->where('type', 'bank')
                ->first());
    }

    public function getSellerCardAccountDetails()
    {
        return response()->json(
            SellerBankDetails::where('seller_id', auth('sanctum')->user()->id)
                ->where('type', 'card')
                ->first());
    }
}
