<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NumberOfProductImages implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // echo '<pre>';
        // print_r(request()->file('images'));
        // die;

        $fileCount = count(request()->file('images'));

        if ($fileCount > 5) {
            $fail('You can only upload 5 images');
        }
    }
}
