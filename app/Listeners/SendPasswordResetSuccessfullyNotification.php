<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Notifications\PasswordResetSuccessfullyNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPasswordResetSuccessfullyNotification implements ShouldQueue
{
    public function handle(PasswordReset $passwordReset): void
    {
        $passwordReset->user->notify(new PasswordResetSuccessfullyNotification);
    }
}
