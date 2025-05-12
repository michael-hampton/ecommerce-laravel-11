<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'cart_value',
        'expires_at',
        'brands',
        'categories',
        'seller_id',
        'usages',
    ];

    protected $dates = ['expires_at'];

    public function categories()
    {
        return empty($this->categories) ? collect() : Category::whereIn('id', explode(',', $this->categories))->get();
    }

    public function brands()
    {
        return empty($this->brands) ? collect() : Brand::whereIn('id', explode(',', $this->brands))->get();
    }
}
