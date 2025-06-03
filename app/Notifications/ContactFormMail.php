<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactFormMail extends Notification
{
    use Queueable;
    protected $user;
    protected $validated;

    /**
     * Create a new notification instance.
     */
    public function __construct($user,$validated)
    {
         $this->user = $user;
        $this->validated = $validated;
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
            ->subject('New contact us Message')
            ->greeting('Hi '.ucfirst($this->user->first_name).'!')
            ->line('They has been a new entry from the contact us form with the following details.')
            ->line('Name: '.$this->validated['name'])
            ->line('Email Address: '.$this->validated['email'])
            ->line('Subject: '.$this->validated['subject'])
            ->line('Message: '.$this->validated['message'])
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
