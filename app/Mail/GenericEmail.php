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

    protected $recipients;
    protected string $templateName;
    protected array $templateParams;
    public function __construct(string $subject, $recipients, string $templateName, array $templateParams)
    {
        $this->subject($subject);
        $this->recipients = config('app.env') === 'production' ? $recipients : env('MAIL_TEST');
        $this->templateName = $templateName;
        $this->templateParams = $templateParams;
    }
    public function build()
    {
        return $this->view($this->templateName)->with($this->templateParams);
    }

    public function sendMail()
    {
        if (!env('SEND_EMAIL')) {
            return;
        }

        Mail::to($this->recipients)->send($this);
    }
}
