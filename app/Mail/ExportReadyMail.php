<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExportReadyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $downloadUrl;

    public function __construct($downloadUrl)
    {
        $this->downloadUrl = $downloadUrl;
    }

    public function build()
    {
        return $this->subject('Your Export is Ready')
            ->markdown('emails.export-ready');
    }
}
