<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Courier extends Model
{
    protected $fillable = ['name', 'code', 'active', 'countries_active'];

    protected $casts = ['active' => 'boolean'];

    public function countries(): HasMany {
        return $this->hasMany(Country::class, 'id', 'country_id');
    }
}
