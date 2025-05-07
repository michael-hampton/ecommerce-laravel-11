<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeValue extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['attribute_id', 'name'];

    public function attribute()
    {
        return $this->hasOne(ProductAttribute::class, 'id', 'attribute_id');

    }
}
