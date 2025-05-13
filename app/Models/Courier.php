<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Courier extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'code', 'active', 'country_id'];

    protected $casts = ['active' => 'boolean'];

    public function country(): HasOne {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
}
