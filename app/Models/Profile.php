<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'website',
        'country',
        'zip',
        'phone',
        'address1',
        'address2',
        'city',
        'state',
        'country',
        'profile_picture',
        'biography',
        'username',
        'email'
    ];
}
