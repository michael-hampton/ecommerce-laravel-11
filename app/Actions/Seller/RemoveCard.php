<?php

declare(strict_types=1);

namespace App\Actions\Seller;

use App\Models\SellerBankDetails;

class RemoveCard
{
    public function handle(int $id)
    {
        return SellerBankDetails::find($id)->delete();
    }
}
