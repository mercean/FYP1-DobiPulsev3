<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class PickupReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;
    protected $type;

    public function __construct($order, $type = 'bulk')
    {
        $this->order = $order;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('📦 Laundry Pickup Reminder')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line("Your {$this->type} laundry order #{$this->order->id} is ready for pickup.")
            ->action('View Order', url("/" . ($this->type === 'bulk' ? 'bulk-orders' : 'orders') . "/{$this->order->id}"))
            ->line('Thank you for using DobiPulse!');
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'title' => 'Laundry Pickup Reminder',
            'body' => "Your {$this->type} order #{$this->order->id} is ready for pickup.",
            'url' => "/" . ($this->type === 'bulk' ? 'bulk-orders' : 'orders') . "/{$this->order->id}",
        ]);
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'Laundry Pickup Reminder',
            'body' => "Your {$this->type} order #{$this->order->id} is ready for pickup.",
            'url' => "/" . ($this->type === 'bulk' ? 'bulk-orders' : 'orders') . "/{$this->order->id}",
        ]);
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Laundry Pickup Reminder',
            'body' => "Your {$this->type} order #{$this->order->id} is ready for pickup.",
            'url' => "/" . ($this->type === 'bulk' ? 'bulk-orders' : 'orders') . "/{$this->order->id}",
        ];
    }
        public function __construct(public $order) {}

    public function via($notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('📦 Pickup Reminder - Order #' . $this->order->id)
            ->greeting('Hi ' . $notifiable->name)
            ->line("Your bulk order #{$this->order->id} is ready for pickup.")
            ->action('View Order', url('/bulk-orders/' . $this->order->id))
            ->line('Thank you for choosing DobiPulse!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Pickup Reminder',
            'body' => "Your bulk order #{$this->order->id} is ready for pickup.",
            'url' => '/bulk-orders/' . $this->order->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'Pickup Reminder',
            'body' => "Your bulk order #{$this->order->id} is ready for pickup.",
            'url' => '/bulk-orders/' . $this->order->id,
        ]);
    }

}
