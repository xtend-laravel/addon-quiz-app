<?php

namespace XtendLunar\Addons\QuizApp\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use XtendLunar\Addons\QuizApp\Models\QuizPrizeTier;

class QuizPrizeTierNotification extends Notification
{
    use Queueable;

    protected string $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected User $user, protected QuizPrizeTier $prizeTier)
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
            ->subject('Congratulations! You have won a prize.')
            ->line('Congratulations!')
            ->line('You have won our '.$this->prizeTier->translate('name').' prize.')
            ->line('Your coupon code is: '.$this->prizeTier->discount?->coupon. ' and it will expire on '.$this->prizeTier->discount?->ends_at->format('d M Y'))
            ->line('Please enter the coupon code at the checkout to redeem your '.$this->prizeTier->percentage_off.'% discount coupon.')
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
