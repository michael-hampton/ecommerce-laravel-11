<?php

declare(strict_types=1);

namespace App\Actions\Seller;

use App\Models\SellerBankDetails;
use App\Services\PaymentProviders\PaymentProviderFactory;
use Illuminate\Http\Request;

class UpdateCard
{
    public function handle(array $data, string $id)
    {
          return (new PaymentProviderFactory())
            ->getClass()
            ->updateCard($id, $data);

        /*$card = SellerBankDetails::findOrFail($id);
        $card->update([
            'card_name' => $request->string('card_name'),
            'card_expiry_date' => $request->string('card_expiry_date'),
            'card_cvv' => $request->string('card_cvv'),
            'card_number' => $request->string('card_number'),
        ]);

        return $card->fresh();*/
    }
}
