<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected $body;
    public function __construct(string $subject, string $body)
    {
        $this->body = $body;
        $this->subject($subject)->from('admin@essentia.com.br', 'Administrador');
    }

    public function build()
    {
        return $this->view('mails.generic')->with(['body' => $this->body]);
    }
}
