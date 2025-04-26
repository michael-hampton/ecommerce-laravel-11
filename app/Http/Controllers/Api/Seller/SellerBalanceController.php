<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Requests\WithdrawBalanceRequest;
use App\Http\Resources\SellerBalanceResource;
use App\Http\Resources\SellerWithdrawalResource;
use App\Models\SellerBalance;
use App\Models\SellerWithdrawal;
use Illuminate\Http\JsonResponse;

class SellerBalanceController
{

    public function show()
    {
        $sellerBalance = SellerBalance::where('seller_id', auth('sanctum')->id())->first();

        return response()->json(SellerbalanceResource::make($sellerBalance));
    }

    /**
     * @param WithdrawBalanceRequest $request
     * @return JsonResponse
     */
    public function withdraw(WithdrawBalanceRequest $request)
    {
        $sellerBalance = SellerBalance::where('seller_id', auth('sanctum')->id())->first();
        $affectedRows = $sellerBalance->decrement('balance', $request->get('amount'));

        if (!empty($affectedRows)) {
            SellerWithdrawal::create([
                'amount' => $request->get('amount'),
                'seller_id' => auth('sanctum')->id()
            ]);
        }

        return response()->json(SellerBalanceResource::make($sellerBalance->fresh()));
    }

    public function getWithdrawals()
    {
        $withdrawals = SellerWithdrawal::where('seller_id', auth('sanctum')->id())->get();

        return response()->json(SellerWithdrawalResource::collection($withdrawals));
    }
}
