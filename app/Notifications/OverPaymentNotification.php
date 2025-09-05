<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OverPaymentNotification extends Notification
{
    use Queueable;
    protected $tenant;
    protected $admin;

    protected $amount;
    protected $month;
    protected $over_paid_amount;

    /**
     * Create a new notification instance.
     */
    public function __construct($tenant, $admin,$amount,$over_paid_amount,$month)
    {
        $this->tenant = $tenant;
        $this->admin = $admin;
        $this->amount = $amount;
        $this->month = $month;
        $this->over_paid_amount = $over_paid_amount;
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
            ->greeting('Hi '.$this->admin->first_name)
            ->subject('New payment has been made')
            ->line('Tenant '.$this->tenant->full_name.' has overpaid below are the details')
            ->line('Tenant '.$this->tenant->full_name.'<br> Amount: '.$this->amount.'<br>'. 'Month: '.$this->month
            )
            ->action('Confirm Transaction', url('/'))
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
