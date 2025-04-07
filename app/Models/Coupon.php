<?php

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
        'usages'
    ];
    protected $dates = ['expires_at'];
}
