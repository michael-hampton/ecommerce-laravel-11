<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UserNotification extends Model
{
    protected $fillable = ['user_id', 'notification_type'];

    public function notificationType(): HasOne {
        return $this->hasOne(NotificationType::class, 'id', 'notification_type');
    }
}
