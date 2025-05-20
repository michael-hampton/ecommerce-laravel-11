<?php

declare(strict_types=1);

namespace App\Actions\Seller;

use App\Models\SellerBankDetails;
use App\Services\PaymentProviders\PaymentProviderFactory;
use Illuminate\Http\Request;

class SaveBankAccount
{
    public function handle(Request $request): SellerBankDetails
    {
        $currentAccount = SellerBankDetails::where('seller_id', auth('sanctum')->user()->id)
            ->where('type', 'bank')
            ->first();

        if (!empty($currentAccount)) {
            (new PaymentProviderFactory())
                ->getClass()
                ->updateBankAccount(auth('sanctum')->user()->id, $currentAccount->payment_method_id, $request->all());

            return $currentAccount;
        }

        $externalAccount = (new PaymentProviderFactory())
            ->getClass()
            ->createBankAccount($request->all(), auth('sanctum')->user()->id);

        return SellerBankDetails::create(['external_account_id' => $externalAccount['id'], 'seller_id' => auth('sanctum')->user()->id, 'type' => 'bank']);

    }
}
