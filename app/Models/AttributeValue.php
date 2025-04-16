<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'name'];

    public function attribute()
    {
        return $this->hasOne(ProductAttribute::class, 'id', 'attribute_id');

    }
}
