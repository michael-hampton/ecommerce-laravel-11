<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttributeValue extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['product_attribute_id', 'attribute_value_id', 'product_id'];

    public function productAttribute(): HasOne
    {
        return $this->hasOne(ProductAttribute::class, 'id', 'product_attribute_id');
    }

    public function productAttributeValue(): HasOne
    {
        return $this->hasOne(AttributeValue::class, 'id', 'attribute_value_id');
    }

    public function product(): HasOne
    {
        return $this->hasOne(AttributeValue::class, 'product_id');
    }
}
