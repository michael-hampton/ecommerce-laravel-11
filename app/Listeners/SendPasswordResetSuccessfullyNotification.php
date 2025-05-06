<?php



namespace App\Listeners;

use App\Notifications\PasswordResetSuccessfullyNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPasswordResetSuccessfullyNotification implements ShouldQueue
{
    public function handle(PasswordReset $event)
    {
        $event->user->notify(new PasswordResetSuccessfullyNotification);
    }
}
