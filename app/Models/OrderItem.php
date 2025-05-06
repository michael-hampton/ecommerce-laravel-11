<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'coupon_id',
        'discount',
        'price',
        'quantity',
        'options',
        'status',
        'seller_id',
        'shipping_id',
        'shipping_price',
        'review_status',
        'tracking_number',
        'courier_id',
        'delivery_date',
        'cancelled_date',
        'commission',
        'approved_date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    protected function scopeSeller(Builder $query, int $sellerId): void
    {
        $query->where('seller_id', '=', $sellerId);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(OrderLog::class, 'order_item_id');
    }

    public function courier(): BelongsTo
    {
        return $this->belongsTo(Courier::class, 'courier_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Post::class, 'order_item_id');
    }
}
