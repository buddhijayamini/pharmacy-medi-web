<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuotationNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $quotation;

    /**
     * Create a new message instance.
     *
     * @param $quotation
     */
    public function __construct($quotation)
    {
        $this->quotation = $quotation;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Quotation Created',
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        return $this->markdown('emails.quotation_notification')
        ->with('quotation', $this->quotation);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
