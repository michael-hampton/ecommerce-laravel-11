<?php

namespace App\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use App\Notifications\PasswordResetSuccessfullyNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPasswordResetSuccessfullyNotification implements ShouldQueue
{
    public function handle(PasswordReset $event)
    {
        $event->user->notify(new PasswordResetSuccessfullyNotification());
    }
}