<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class GenericEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $body;
    /**
     * Create a new message instance.
     */
    public function __construct($recipients, $subject, $body)
    {
        $this->body = $body;

        $this->to($recipients)
            ->subject($subject)
            ->from('admin@essentia.com.br', 'Administrador')
            ->replyTo('luis.pedro@essentia.com.br', 'Luís Pedro')
            ->markdown('mails.generic', ['body' => $body]);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $html = view('mails.generic', ['body' => $this->body])->render();
        return new Content(
            html: $html,
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            // Attachment::fromPath('/path/to/file')
            //     ->as('name.pdf')
            //     ->withMime('application/pdf'),

            // Attachment::fromStorage('/path/to/file')
            // ->as('name.pdf')
            // ->withMime('application/pdf'),

            // Attachment::fromStorageDisk('s3', '/path/to/file')
            // ->as('name.pdf')
            // ->withMime('application/pdf'),

            // Attachment::fromData(fn () => $this->pdf, 'Report.pdf')
            // ->withMime('application/pdf'),
        ];
    }
}
