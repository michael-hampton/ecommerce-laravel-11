<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryMethod extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country_id', 'price', 'courier_id'];

    protected $casts = ['tracking' => 'bool'];

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }
}
