<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class GenericEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected $body;
    protected $recipients;
    public function __construct(string $subject, string $body, $recipients)
    {
        $this->body = $body;
        $this->subject($subject);
        $this->recipients = config('app.env') === 'production' ? $recipients : auth()->user()->email;
    }
    public function build()
    {
        return $this->view('mails.generic')->with(['body' => $this->body]);
    }

    public function sendMail()
    {
        if (!env('SEND_EMAIL')) {
            return;
        }

        Mail::to($this->recipients)->send($this);
    }
}
