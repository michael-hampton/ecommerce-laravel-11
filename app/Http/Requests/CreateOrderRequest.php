<?php



namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'filled|string|max:100',
            'mode' => 'required',
            'phone' => 'filled|numeric',
            'address' => 'required_without:name',
            'city' => 'filled|string',
            'state' => 'filled|string',
            'zip' => 'filled|string',
            'country' => 'filled|integer|exists:countries,id',
        ];
    }
}
