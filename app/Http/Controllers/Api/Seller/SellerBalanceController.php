<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Requests\WithdrawBalanceRequest;
use App\Http\Resources\SellerBalanceResource;
use App\Http\Resources\SellerWithdrawalResource;
use App\Models\SellerBalance;
use App\Models\SellerWithdrawal;
use App\Models\Transaction;
use App\Repositories\Interfaces\ISellerRepository;
use App\Services\Interfaces\ISellerService;
use Illuminate\Http\JsonResponse;

class SellerBalanceController
{
    public function __construct(private ISellerService $sellerService)
    {

    }


    public function show()
    {
        $sellerBalance = SellerBalance::where('seller_id', auth('sanctum')->id())->get();

        return response()->json([
            'balances' => SellerBalanceResource::collection($sellerBalance),
            'current' => SellerBalanceResource::make($sellerBalance->sortBy('balance')->first())
        ]);
    }

    /**
     * @param WithdrawBalanceRequest $request
     * @return JsonResponse
     */
    public function withdraw(WithdrawBalanceRequest $request)
    {
        $result = $this->sellerService->withdrawFunds($request->all());

        return response()->json(SellerBalanceResource::make($result));
    }

    public function getWithdrawals()
    {
        $withdrawals = SellerWithdrawal::where('seller_id', auth('sanctum')->id())->get();

        return response()->json(SellerWithdrawalResource::collection($withdrawals));
    }
}
