<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function deliveryMethods()
    {
        return $this->hasMany(DeliveryMethod::class, 'country_id');
    }
}
