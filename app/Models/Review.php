<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment', 
        'rating', 
        'commentable_type', 
        'commentable_id', 
        'user_id',
        'parent_id'
    ];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function replies(): HasOne {
        return $this->hasOne(Review::class,'parent_id');
    }
}
