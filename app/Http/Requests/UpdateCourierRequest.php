<?php

namespace App\Http\Requests;

use App\Models\Courier;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCourierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
         return Auth::user()->can('update', Courier::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
              'name' => 'required|string|max:255|unique:couriers,name,'.request()->get('id'),
        ];
    }
}
