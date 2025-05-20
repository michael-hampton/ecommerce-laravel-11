<?php



namespace App\Http\Controllers\Api\Seller;

use App\Actions\Seller\SaveBankAccount;
use App\Actions\Seller\SaveBillingInformation;
use App\Actions\Seller\UpdateSeller;
use App\Actions\Seller\WithdrawFunds;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\ActivateSellerAccountRequest;
use App\Http\Requests\WithdrawBalanceRequest;
use App\Http\Resources\SellerBalanceResource;
use App\Http\Resources\SellerWithdrawalResource;
use App\Models\SellerBalance;
use App\Models\SellerWithdrawal;
use App\Models\WithdrawalTypeEnum;
use App\Services\PaymentProviders\PaymentProviderFactory;
use App\Services\PaymentProviders\Stripe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SellerBalanceController extends ApiController
{
    public function show()
    {
        $sellerBalance = SellerBalance::where('seller_id', auth('sanctum')->id())->get();

        if ($sellerBalance->isEmpty()) {
            return $this->success([], 'No record');
        }

        return response()->json([
            'balances' => SellerBalanceResource::collection($sellerBalance),
            'pending_owed' => $sellerBalance->where('status', 'pending')->where('type', WithdrawalTypeEnum::OrderReceived->value)->sum(function ($item) {
                return round($item->previous_balance - $item->balance, 2);
            }),
            'pending_owing' => $sellerBalance->where('status', 'pending')->where('type', WithdrawalTypeEnum::OrderSpent->value)->sum(function ($item) {
                return round($item->previous_balance - $item->balance, 2);
            }),
            'current' => SellerBalanceResource::make($sellerBalance->sortByDesc('created_at')->first()),
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function withdraw(WithdrawBalanceRequest $withdrawBalanceRequest, WithdrawFunds $withdrawFunds)
    {
        $result = $withdrawFunds->handle($withdrawBalanceRequest->all());

        return response()->json(SellerBalanceResource::make($result));
    }

    public function getWithdrawals()
    {
        $withdrawals = SellerWithdrawal::where('seller_id', auth('sanctum')->id())->get();

        return response()->json(SellerWithdrawalResource::collection($withdrawals));
    }

    public function activate(ActivateSellerAccountRequest $request, SaveBillingInformation $saveBillingInformation, SaveBankAccount $saveBankAccount, UpdateSeller $updateSeller)
    {
        (new PaymentProviderFactory())
            ->getClass()
            ->createAccount($request->all(), auth('sanctum')->user()->id);

        $result1 = $saveBillingInformation->handle($request);
        //$sellerBankDetails = $saveBankAccount->handle($request);
        $result3 = $updateSeller->handle(array_merge($request->all(), ['balance_activated' => true]), auth('sanctum')->user()->profile->id);

        return $result1 && $result3 ? $this->success($result1, 'Balance Activated') : $this->error('Balance could not be activated');

    }

    public function createPaymentIntent() {
        $intentId = (new Stripe())->createSetupIntent();

        return response()->json(['id' => $intentId]);
    }
}
