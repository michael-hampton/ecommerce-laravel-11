<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'regular_price',
        'sale_price',
        'stock_status',
        'featured',
        'quantity',
        'images',
        'image',
        'brand_id',
        'category_id',
        'SKU',
        'seller_id',
        'package_size',
        'active',
    ];

    protected $casts = ['active' => 'bool', 'featured' => 'bool'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    protected function scopeFeatured(Builder $query): void
    {
        $query->where('featured', '=', 1);
    }

    protected function scopeOnSale(Builder $query): void
    {
        $query->whereNotNull('sale_price')
            ->where('sale_price', '<>', '')
            ->whereRaw('sale_price < regular_price');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'commentable');
    }

    public function productAttributes(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class, 'product_id', 'id');
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}
