<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $casts = ['shipping_active' => 'bool'];

    protected $fillable = ['shipping_active'];

    public $timestamps = false;

    public function deliveryMethods()
    {
        return $this->hasMany(DeliveryMethod::class, 'country_id');
    }
}
