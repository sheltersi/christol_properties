<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ShortPaymentNotification extends Notification
{
    use Queueable;
    protected $amount, $month, $remaining_balance, $tenant;

    /**
     * Create a new notification instance.
     */
    public function __construct($tenant,$amount, $month, $remaining_balance)
    {
        $this->amount = $amount;
        $this->month = $month;
        $this->month = $remaining_balance;
        $this->tenant = $tenant;
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
            ->greeting('Hi '.$this->tenant->name)
            ->subject('New Payment Notification')
            ->line('Your updated payment details for amount R'.$this->amount.' for the month of'.$this->month.' has been received. Please make a full payment as soon as possible')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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
