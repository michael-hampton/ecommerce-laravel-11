<?php

namespace App\Actions\Seller;

use App\Models\SellerBankDetails;

class DeleteBankAccount
{

    public function handle(int $id) {
        return SellerBankDetails::find($id)->delete();
    }
}
