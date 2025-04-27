<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerBalance extends Model
{
    use HasFactory;

    protected $table = 'seller_balance';

    public $timestamps = false;

    protected $fillable = ['balance', 'seller_id', 'previous_balance', 'transaction_id'];
}
