<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory;
    use SoftDeletes;

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
        'email',
        'balance_activated',
        'date_of_birth',
        'external_customer_id',
        'external_account_id'
    ];

    protected $casts = ['active' => 'boolean'];
}
