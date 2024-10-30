<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Hello ' . $this->order->user->name . ',')
                    ->line('The status of your order #' . $this->order->id . ' has been updated to ' . ucfirst($this->order->order_status->value) . '.')
                    ->action('View Order', url('/orders/' . $this->order->id))
                    ->line('Thank you for shopping with us!');
    }
}
