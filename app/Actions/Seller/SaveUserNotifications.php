<?php

namespace App\Actions\Seller;

use App\Models\UserNotification;

class SaveUserNotifications
{
    public function handle(array $data): bool 
    {
        UserNotification::where('user_id', $data['user_id'])->forceDelete();

        foreach ($data['notification_types'] as $notificationType => $notificationType) {
            UserNotification::create(['user_id' => $data['user_id'], 'notification_type' => $notificationType]);
        }
        return true;
    }
}
