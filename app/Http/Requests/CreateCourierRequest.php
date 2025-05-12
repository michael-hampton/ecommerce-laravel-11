<?php

namespace App\Http\Requests;

use App\Models\Courier;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateCourierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
       return Auth::user()->can('create', Courier::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255|unique:couriers,name',
        ];
    }
}
