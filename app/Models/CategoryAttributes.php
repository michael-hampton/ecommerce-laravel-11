<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryAttributes extends Model
{
    protected $fillable = ['attribute_id', 'category_id'];
    public $timestamps = false;

    public function attribute() {
        return $this->belongsTo(ProductAttribute::class);
    }

}
