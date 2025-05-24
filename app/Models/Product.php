<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

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

    /**
     * Auditable events.
     *
     * @var array
     */
    protected $auditEvents = [
        'deleted',
        'restored',
        'updated'
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

    protected function scopeFeatured(Builder $builder): void
    {
        $builder->where('featured', '=', 1);
    }

    protected function scopeOnSale(Builder $builder): void
    {
        $builder->whereNotNull('sale_price')
            ->where('sale_price', '<>', '')
            ->whereRaw('sale_price < regular_price');
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'commentable')->orderBy('rating', 'desc');
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
