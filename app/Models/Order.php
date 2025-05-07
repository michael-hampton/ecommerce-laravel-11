<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'subtotal',
        'shipping',
        'discount',
        'tax',
        'status',
        'is_shipping_different',
        'note',
        'delivery_date',
        'cancelled_date',
        'address_id',
        'review_status',
        'total',
        'commission',
        'tracking_number',
        'courier_id',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function lineTotal()
    {
        return $this->orderItems->where('seller_id', auth()->id())->sum('price');
    }

    public function totalCount()
    {
        return $this->orderItems->where('seller_id', auth()->id())->count();
    }

    public function subtotal(): float
    {
        $orderItems = $this->orderItems->where('seller_id', auth()->id());

        $total = 0;

        foreach ($orderItems as $orderItem) {
            $total += $orderItem->price * $orderItem->quantity;
            $total += $orderItem->shipping_price;
        }

        $total += $this->commission;

        return round($total, 2);
    }

    public function shipping(): float
    {
        $orderItems = $this->orderItems->where('seller_id', auth()->id());

        $total = 0;

        foreach ($orderItems as $orderItem) {
            $total += $orderItem->shipping_price;
        }

        return round($total, 2);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'order_id');
    }

    public function logs()
    {
        return $this->hasMany(OrderLog::class, 'order_id');
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_id');
    }
}
