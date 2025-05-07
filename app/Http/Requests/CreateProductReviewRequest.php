<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductReviewRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'customerId' => 'required|integer|exists:users,id',
            'review' => 'required|string',
            'rating' => 'required|integer',
            'productId' => 'required|integer|exists:products,id',
            'orderItemId' => 'required|integer|exists:order_items,id',
        ];
    }
}
