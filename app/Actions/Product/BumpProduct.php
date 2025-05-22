<?php

namespace App\Actions\Product;

use App\Models\Product;
use App\Models\WithdrawalEnum;
use App\Models\WithdrawalTypeEnum;
use App\Services\WithdrawalService;

class BumpProduct
{
    public function handle(int $bumpDays, Product $product): bool
    {
        if ($bumpDays === 0) {
            return false;
        }

        $costs = config('shop.bump');

        $price = $costs[$bumpDays];

        (new WithdrawalService(
            auth()->id(),
            $price,
            WithdrawalTypeEnum::BumpProduct,
            WithdrawalEnum::Decrease,
            $product->id
        ))->updateBalance()->withdraw();

        $product->update(['featured' => true]);

        return true;
    }
}
