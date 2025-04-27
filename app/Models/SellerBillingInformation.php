<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerBillingInformation extends Model
{
    protected $fillable = [
        'country_id',
        'zip',
        'address1',
        'address2',
        'city',
        'state',
        'seller_id'
    ];

    protected $table = 'seller_billing_information';
}
