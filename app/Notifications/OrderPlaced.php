<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderPlaced extends Notification
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
        $mailMessage = (new MailMessage)
                        ->greeting('Hello ' . $this->order->user->name . ',')
                        ->line('Your order #' . $this->order->id . ' has been placed successfully.')
                        ->line('Order Total: $' . $this->order->total_price)
                        ->action('View Order', url('/orders/' . $this->order->id))
                        ->line('Thank you for shopping with us!');

        // Add each item in the order
        foreach ($this->order->orderItems as $item) {
            $mailMessage->line($item->book->name . ' - $' . $item->price . ' x ' . $item->quantity);
        }

        return $mailMessage;
    }

}
