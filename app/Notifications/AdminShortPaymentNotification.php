<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminShortPaymentNotification extends Notification
{
    use Queueable;

    protected $admin, $tenant,$amount, $month, $remaining_balance;

    /**
     * Create a new notification instance.
     */
    public function __construct($admin,$tenant,$amount, $month, $remaining_balance)
    {
        $this->admin = $admin;
        $this->tenant = $tenant;
        $this->amount = $amount;
        $this->month = $month;
        $this->remaining_balance = $remaining_balance;
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
            ->greeting('Hello '.$this->admin->first_name)
            ->subject('Kindly note that tenant '.$this->tenant->full_name. 'has made a short payment of R'.$this->amount. ' for the month of '.$this->month.'. You will be notified once they have completed their payment.')
            ->action('Login', url('/'))
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
