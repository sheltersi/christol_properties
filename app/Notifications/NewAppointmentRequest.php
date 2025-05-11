<?php

namespace App\Notifications;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAppointmentRequest extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable, InteractsWithSockets;

    protected $appointment;
    /**
     * Create a new notification instance.
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database','broadcast'];
    }

    public function toBroadcast($notifiable)
    {
        return (new BroadcastMessage([
            'data' => $this->toArray($notifiable),
            'read_at' => null,
            'created_at' => now()->toDateTimeString(),
        ]))->onConnection('redis') // optional: if using Redis
          ->onQueue('default')     // optional
          ->broadcastOn(new PrivateChannel('App.Models.User.' . $notifiable->id));
    }



    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Appointment Booked')
            ->line('The introduction to the notification.')
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
            'appointment_id' => $this->appointment->id,
            'user_name' => $this->appointment->user->name,
            'preferred_date' => $this->appointment->preferred_date,
            'preferred_time' => $this->appointment->preferred_time,
            'message' => $this->appointment->message,
        ];
    }
}
