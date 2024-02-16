<?php

namespace XtendLunar\Addons\QuizApp\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Lunar\Models\Discount;

class QuizWinnerNotification extends Notification
{
    use Queueable;

    protected string $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected User $user, protected Discount $discount)
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Congratulations! You are the winner of the quiz.')
            ->line('Congratulations!')
            ->line('You are the winner of the quiz.')
            ->line('You have won our grand prize.')
            ->line('Your coupon code is: '.$this->discount->coupon. ' and it will expire on '.$this->discount->ends_at->format('d M Y'))
            ->line('Please enter the coupon code at the checkout to redeem your 100% discount grand prize.')
            ->action('Visit our store', url('https://awraaf.com'));
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
