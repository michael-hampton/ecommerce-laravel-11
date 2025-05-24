<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
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
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->symbols()],
            'mobile' => ['required', 'string', 'max:12'],
            'name' => ['required', 'max:255']
        ];
    }

    public function messages(): array
    {
        return [
            'password' => 'The password field must contain at least one letter, one number and a special character.
'
        ];
    }
}
