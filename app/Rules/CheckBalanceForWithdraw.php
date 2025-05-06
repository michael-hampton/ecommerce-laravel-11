<?php



namespace App\Rules;

use App\Models\SellerBalance;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class CheckBalanceForWithdraw implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $sellerBalance = SellerBalance::where('seller_id', auth('sanctum')->user()->id)->orderBy('balance')->first();

        if ($sellerBalance->balance < request()->float('amount')) {
            $fail('Insufficient funds');
        }
    }
}
