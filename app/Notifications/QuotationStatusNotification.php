<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QuotationStatusNotification extends Notification
{
    use Queueable;

    protected $quotation;
    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($quotation, $status)
    {
        $this->quotation = $quotation;
        $this->status = $status;
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
            ->subject('Quotation Status Notification')
            ->line('Your quotation with ID ' . $this->quotation->id . ' has been ' . $this->status)
            ->action('View Quotation', url('/quotation/' . $this->quotation->id))
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
