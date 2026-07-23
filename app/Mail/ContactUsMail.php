<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Contact Message: ' . $this->data['subject'],
            replyTo: [
                new \Illuminate\Mail\Mailables\Address($this->data['email'], $this->data['name'] ?? 'Visitor'),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact-us',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
