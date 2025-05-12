<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerBankDetails extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'account_name',
        'account_number',
        'bank_name',
        'bank_code',
        'sort_code',
        'card_type',
        'card_number',
        'card_expiry_date',
        'card_cvv',
        'seller_id',
        'card_name',
        'card_sort_code',
        'type',
    ];

    public function casts()
    {
        return ['card_number' => 'string'];
    }
}
