<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentConfirmed extends Notification
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
            ->line('Your payment has been successfully processed.')
            ->line('Order ID: ' . $this->order->id)
            ->line('Total Amount: $' . $this->order->total_price)
            ->line('Thank you for your purchase!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
