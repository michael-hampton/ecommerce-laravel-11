<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Product;
use App\Rules\NumberOfProductImages;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('create', Product::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:brands,name|max:100',
            'slug' => 'required|unique:products,slug',
            'category_id' => 'required',
            'brand_id' => 'required',
            'short_description' => 'required|max:100',
            'description' => 'required|max:250',
            'regular_price' => 'required',
            //'sale_price' => 'required',
            //'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required',
            'quantity' => 'required',
            'image' => ['required', 'mimes:png,jpg,jpeg', 'max:2048'],
            'images.*' => ['sometimes', 'mimes:png,jpg,jpeg', 'max:2048'],
            'images' => new NumberOfProductImages
        ];
    }
}
