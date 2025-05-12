<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    
    protected $casts = ['shipping_active' => 'bool'];

    protected $fillable = ['shipping_active', 'code', 'name'];

    public $timestamps = false;

    public function deliveryMethods()
    {
        return $this->hasMany(DeliveryMethod::class, 'country_id');
    }
}
