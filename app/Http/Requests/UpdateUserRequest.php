<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|max:255:min:3|unique:users,name,'.request()->route('id'),
            'email' => 'required|email|unique:users,email,'.request()->route('id'),
            'mobile' => 'required|numeric|digits:12|unique:users,mobile,'.request()->route('id'),
            'password' => 'required|min:6|confirmed',
        ];
    }
}
