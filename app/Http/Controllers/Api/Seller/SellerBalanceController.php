<?php

namespace App\Http\Controllers\Api\Seller;

use App\Actions\Seller\WithdrawFunds;
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
        $sellerBalance = SellerBalance::where('seller_id', auth('sanctum')->id())->get();

        return response()->json([
            'balances' => SellerBalanceResource::collection($sellerBalance),
            'current' => SellerBalanceResource::make($sellerBalance->sortByDesc('created_at')->first())
        ]);
    }

    /**
     * @param WithdrawBalanceRequest $request
     * @return JsonResponse
     */
    public function withdraw(WithdrawBalanceRequest $request, WithdrawFunds $withdrawFunds)
    {
        $result = $withdrawFunds->handle($request->all());

        return response()->json(SellerBalanceResource::make($result));
    }

    public function getWithdrawals()
    {
        $withdrawals = SellerWithdrawal::where('seller_id', auth('sanctum')->id())->get();

        return response()->json(SellerWithdrawalResource::collection($withdrawals));
    }
}
