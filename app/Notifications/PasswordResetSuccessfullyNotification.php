<?php



namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetSuccessfullyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Password Reset Successful')
            ->greeting('Hello!')
            ->line('Your password has been successfully reset.')
            ->line('If you did not reset your password, please contact support immediately.')
            ->action('Login to Your Account', url('/login'))
            ->line('Thank you for using our application!');
    }
}
