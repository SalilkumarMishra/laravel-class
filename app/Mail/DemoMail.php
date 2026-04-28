<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DemoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $subject,
        public string $message,
        public string $senderName,
        public ?string $cc = null,
        public ?string $bcc = null,
        public ?string $replyTo = null,
        public ?string $attachmentPath = null,
        public ?string $attachmentName = null,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), $this->senderName),
            subject: $this->subject,
            cc: $this->cc ? [new Address($this->cc)] : [],
            bcc: $this->bcc ? [new Address($this->bcc)] : [],
            replyTo: $this->replyTo ? [new Address($this->replyTo)] : [],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.demo-message',
            with: [
                'messageBody' => $this->message,
            ],
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        if (! $this->attachmentPath) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('public', $this->attachmentPath)
                ->as($this->attachmentName ?? basename($this->attachmentPath)),
        ];
    }
}
