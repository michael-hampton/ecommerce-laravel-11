<?php

namespace App\Actions\User;

use App\Models\NotificationTypeEnum;
use App\Models\Profile;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterUser
{

    public function handle(array $data)
    {
        $notifications = NotificationTypeEnum::cases();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
            'active' => true,
            'utype' => empty($data['seller_account']) ? 'USR' : 'ADM',
        ]);

        $user->createToken('MyAppToken')->plainTextToken;

        if (!empty($data['seller_account'])) {
            Profile::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['mobile'],
                'user_id' => $user->id,
                'active' => false,
            ]);

            foreach ($notifications as $notification) {
                UserNotification::create(['user_id' => $user->id, 'notification_type' => $notification->value]);
            }
        }

        event(new Registered($user));

        return $user;
    }
}
