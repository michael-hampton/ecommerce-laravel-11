<?php

namespace App\Http\Requests;

use App\Models\PackageSizeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDeliveryMethodRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name.*' => [Rule::enum(PackageSizeEnum::class)],
            'price.*' => 'required|numeric|min:1|max:10000',
            'country_id' => 'required|exists:countries,id',
            'courier_id.*' => 'required|exists:couriers,id',
        ];
    }

    public function prepareForValidation()
    {
        return $this->merge(['methods' => json_decode($this->methods, true)]);
    }
}
