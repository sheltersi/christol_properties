<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentNotification extends Notification
{
    use Queueable;

    protected $tenant;

    /**
     * Create a new notification instance.
     */
    public function __construct($tenant)
    {
        $this->tenant = $tenant;
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
         ->subject('New Rent Payment Submitted')
            ->greeting('Hello Chris')
            ->line("A new rent payment has been submitted by tenant: {$this->tenant->full_name}")
            ->action('Review Payment', url('/admin/payments')) // or route('admin.payments.index')
            ->line('Please log in to confirm or reject the payment.');
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
