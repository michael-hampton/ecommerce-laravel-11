<?php

namespace App\Actions\Seller;

use App\Models\SellerBankDetails;

class RemoveCard
{
    public function handle(int $id) {
        return SellerBankDetails::find($id)->delete();

    }
}
