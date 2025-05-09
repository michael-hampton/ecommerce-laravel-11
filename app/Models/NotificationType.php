<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationType extends Model
{
    public $fillable = ['name', 'description'];
    public $timestamps = false;
}
