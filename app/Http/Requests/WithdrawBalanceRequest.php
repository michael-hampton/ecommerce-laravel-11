<?php



namespace App\Http\Requests;

use App\Rules\CheckBalanceForWithdraw;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class WithdrawBalanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:1', new CheckBalanceForWithdraw],
            'transactionId' => ['sometimes', 'numeric', 'exists:transactions,id'],
        ];
    }
}
