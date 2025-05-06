<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $fillable = ['name', 'code', 'active', 'countries_active'];

    protected $casts = ['active' => 'boolean'];
}
