<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerWithdrawal extends Model
{
    protected $fillable = [
        'amount',
        'seller_id',
        'transaction_id',
        'order_id',
        'product_id'
    ];
}
