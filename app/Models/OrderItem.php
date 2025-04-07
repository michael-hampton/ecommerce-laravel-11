<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'quantity',
        'options',
        'status',
        'seller_id',
        'shipping_id',
        'shipping_price',
        'review_status',
        'tracking_number',
        'courier_name',
        'delivery_date',
        'cancelled_date',
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function seller() {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_id');
    }

    protected function scopeSeller(Builder $query, int $sellerId): void
    {
        $query->where('seller_id', '=', $sellerId);
    }

    public function logs()
    {
        return $this->hasMany(OrderLog::class , 'order_item_id');
    }
}
