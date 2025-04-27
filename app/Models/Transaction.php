<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'customer_id',
        'seller_id',
        'order_id',
        'payment_method',
        'payment_status',
        'commission',
        'total',
        'shipping',
        'discount',
        'withdrawn'
    ];

    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function customer() {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function seller() {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
