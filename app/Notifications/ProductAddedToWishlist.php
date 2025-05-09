<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\NotificationTypeEnum;
use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ProductAddedToWishlist extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private User $user, private Product $product)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {

        $notificationTypes = $notifiable->notifications()->with('notificationType')->get()->keyBy('notificationType.id');

        if (empty($notificationTypes->get(NotificationTypeEnum::ADDED_TO_WISHLIST->value))) {
            return [];
        }

        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line(new HtmlString('<strong>' . $this->user->name . '</strong> added your product <strong>' . $this->product->name . '</strong> to their wishlist'))
            // ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => $this->user->name . 'added your product ' . $this->product->name . ' to their wishlist',
            // Add any additional data you want to store in the database
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
