<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $fields;

    /**
     * Create a new message instance.
     */
    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Randevu Detayları',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.details',
            with: [
                'name' => $this->fields["name"],
                "date" => $this->fields["date"],
                "price" => $this->fields["price"],
                "time" => $this->fields["time"],
                "contact_email" => $this->fields["contact_email"],
                "verifyCode" => $this->fields["verifyCode"],
                "site_url" => $this->fields["site_url"]
            ]
        );
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
